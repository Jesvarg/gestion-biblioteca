<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Usuario;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function prestamosVencidos()
    {
        $prestamosVencidos = Prestamo::vencidos()
            ->with(['usuario', 'libro.autor'])
            ->orderBy('fecha_devolucion_esperada')
            ->get();
        
        return view('reportes.prestamos-vencidos', compact('prestamosVencidos'));
    }

    public function librosPopulares(Request $request)
    {
        $periodo = $request->get('periodo', 30); // días
        
        $librosPopulares = Libro::withCount(['prestamos' => function($query) use ($periodo) {
            $query->where('created_at', '>=', now()->subDays($periodo));
        }])
        ->with('autor')
        ->orderBy('prestamos_count', 'desc')
        ->take(20)
        ->get();
        
        return view('reportes.libros-populares', compact('librosPopulares', 'periodo'));
    }

    public function usuariosMorosos()
    {
        $usuariosMorosos = Usuario::where('multa_pendiente', '>', 0)
            ->orWhereHas('prestamos', function($query) {
                $query->vencidos();
            })
            ->with(['prestamos' => function($query) {
                $query->vencidos()->with('libro');
            }])
            ->orderBy('multa_pendiente', 'desc')
            ->get();
        
        return view('reportes.usuarios-morosos', compact('usuariosMorosos'));
    }

    public function estadisticas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));
        
        // Estadísticas por período
        $prestamosDelPeriodo = Prestamo::whereBetween('created_at', [$fechaInicio, $fechaFin])->count();
        $devolucionesDelPeriodo = Prestamo::whereBetween('fecha_devolucion_real', [$fechaInicio, $fechaFin])->count();
        
        // Préstamos por categoría
        $prestamosPorCategoria = DB::table('prestamos')
            ->join('libros', 'prestamos.libro_id', '=', 'libros.id')
            ->join('categorias', 'libros.categoria_id', '=', 'categorias.id')
            ->whereBetween('prestamos.created_at', [$fechaInicio, $fechaFin])
            ->select('categorias.nombre', DB::raw('count(*) as total'))
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderBy('total', 'desc')
            ->get();
        
        // Préstamos por mes (últimos 12 meses)
        $prestamosPorMes = DB::table('prestamos')
            ->select(
                DB::raw('YEAR(created_at) as año'),
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->get();
        
        return view('reportes.estadisticas', compact(
            'fechaInicio',
            'fechaFin',
            'prestamosDelPeriodo',
            'devolucionesDelPeriodo',
            'prestamosPorCategoria',
            'prestamosPorMes'
        ));
    }
}
