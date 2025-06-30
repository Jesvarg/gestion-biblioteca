<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Usuario;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalLibros = Libro::count();
        $totalUsuarios = Usuario::where('tipo_usuario', '!=', 'bibliotecario')->count();
        $prestamosActivos = Prestamo::activos()->count();
        $prestamosVencidos = Prestamo::vencidos()->count();
        
        // Libros más prestados (últimos 30 días)
        $librosPrestados = Libro::withCount(['prestamos' => function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        }])
        ->orderBy('prestamos_count', 'desc')
        ->take(5)
        ->get();
        
        // Préstamos recientes
        $prestamosRecientes = Prestamo::with(['usuario', 'libro'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Usuarios con más préstamos
        $usuariosActivos = Usuario::withCount(['prestamos' => function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        }])
        ->where('tipo_usuario', '!=', 'bibliotecario')
        ->orderBy('prestamos_count', 'desc')
        ->take(5)
        ->get();
        
        // Datos para gráficos (últimos 7 días)
        $prestamosUltimaSemana = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i);
            $prestamosUltimaSemana[] = [
                'fecha' => $fecha->format('d/m'),
                'cantidad' => Prestamo::whereDate('created_at', $fecha)->count()
            ];
        }
        
        return view('dashboard', compact(
            'totalLibros',
            'totalUsuarios', 
            'prestamosActivos',
            'prestamosVencidos',
            'librosPrestados',
            'prestamosRecientes',
            'usuariosActivos',
            'prestamosUltimaSemana'
        ));
    }
}
