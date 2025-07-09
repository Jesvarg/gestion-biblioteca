<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Usuario;
use App\Models\Libro;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestamo::with(['usuario', 'libro', 'bibliotecarioPrestamo']);
        
        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->has('vencidos') && $request->vencidos) {
            $query->vencidos();
        }
        
        if ($request->has('usuario') && $request->usuario) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('nombre', 'LIKE', "%{$request->usuario}%")
                  ->orWhere('apellido', 'LIKE', "%{$request->usuario}%")
                  ->orWhere('codigo_estudiante', 'LIKE', "%{$request->usuario}%");
            });
        }
        
        $prestamos = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $usuarios = Usuario::activos()->orderBy('apellido')->get();
        $libros = Libro::disponibles()->with('autor')->orderBy('titulo')->get();
        
        return view('prestamos.create', compact('usuarios', 'libros'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'libro_id' => 'required|exists:libros,id',
            'dias_prestamo' => 'required|integer|min:1|max:30',
            'observaciones' => 'nullable|string'
        ]);
        
        $usuario = Usuario::findOrFail($validated['usuario_id']);
        $libro = Libro::findOrFail($validated['libro_id']);
        
        // Validaciones de negocio
        if (!$usuario->puedePrestar()) {
            return back()->withErrors([
                'usuario_id' => 'El usuario no puede realizar préstamos en este momento.'
            ]);
        }
        
        if (!$libro->estaDisponible()) {
            return back()->withErrors([
                'libro_id' => 'El libro no está disponible para préstamo.'
            ]);
        }
        
        // Crear préstamo
        $prestamo = Prestamo::create([
            'usuario_id' => $validated['usuario_id'],
            'libro_id' => $validated['libro_id'],
            'fecha_prestamo' => now(),
            'fecha_devolucion_esperada' => now()->addDays($validated['dias_prestamo']),
            'observaciones' => $validated['observaciones'],
            'bibliotecario_prestamo_id' => auth()->id()
        ]);
        
        // Actualizar disponibilidad del libro
        $libro->decrement('cantidad_disponible');
        
        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Préstamo registrado exitosamente.');
    }

    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['usuario', 'libro.autor', 'bibliotecarioPrestamo', 'bibliotecarioDevolucion']);
        
        return view('prestamos.show', compact('prestamo'));
    }

    public function edit(Prestamo $prestamo)
    {
        $prestamo->load(['usuario', 'libro.autor']);
        
        return view('prestamos.edit', compact('prestamo'));
    }

    public function devolver(Request $request, Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'activo') {
            return back()->with('error', 'Este préstamo ya fue devuelto.');
        }
        
        $validated = $request->validate([
            'observaciones_devolucion' => 'nullable|string'
        ]);
        
        // Calcular multa si está vencido
        $multa = $prestamo->calcularMulta();
        
        // Actualizar préstamo
        $prestamo->update([
            'fecha_devolucion_real' => now(),
            'estado' => 'devuelto',
            'multa' => $multa,
            'observaciones' => $prestamo->observaciones . '\n' . ($validated['observaciones_devolucion'] ?? ''),
            'bibliotecario_devolucion_id' => auth()->id()
        ]);
        
        // Actualizar disponibilidad del libro
        $prestamo->libro->increment('cantidad_disponible');
        
        // Actualizar multa del usuario si corresponde
        if ($multa > 0) {
            $prestamo->usuario->increment('multa_pendiente', $multa);
        }
        
        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Devolución registrada exitosamente.' . 
                   ($multa > 0 ? " Multa aplicada: $" . number_format($multa, 2) : ''));
    }

    public function renovar(Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'activo') {
            return back()->with('error', 'Solo se pueden renovar préstamos activos.');
        }
        
        if ($prestamo->estaVencido()) {
            return back()->with('error', 'No se pueden renovar préstamos vencidos.');
        }
        
        // Extender fecha de devolución por 7 días más
        $prestamo->update([
            'fecha_devolucion_esperada' => $prestamo->fecha_devolucion_esperada->addDays(7),
            'estado' => 'renovado'
        ]);
        
        return back()->with('success', 'Préstamo renovado exitosamente.');
    }
}
