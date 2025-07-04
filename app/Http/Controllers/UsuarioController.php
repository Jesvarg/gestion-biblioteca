<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::query();
        
        if ($request->has('buscar') && $request->buscar) {
            $termino = $request->buscar;
            $query->where(function($q) use ($termino) {
                $q->where('nombre', 'LIKE', "%{$termino}%")
                  ->orWhere('apellido', 'LIKE', "%{$termino}%")
                  ->orWhere('email', 'LIKE', "%{$termino}%")
                  ->orWhere('codigo_estudiante', 'LIKE', "%{$termino}%");
            });
        }
        
        if ($request->has('tipo') && $request->tipo) {
            $query->where('tipo_usuario', $request->tipo);
        }
        
        if ($request->has('estado') && $request->estado) {
            $query->where('estado', $request->estado);
        }
        
        $usuarios = $query->paginate(15);
        
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_estudiante' => 'nullable|string|max:20|unique:usuarios',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'tipo_usuario' => 'required|in:estudiante,profesor,bibliotecario,admin'
        ]);
        
        $usuario = Usuario::create($validated);
        
        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuario registrado exitosamente.');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load(['prestamos.libro', 'reservas.libro']);
        
        $prestamosActivos = $usuario->prestamos()->activos()->with('libro')->get();
        $historialPrestamos = $usuario->prestamos()->with('libro')
            ->orderBy('created_at', 'desc')->take(10)->get();
        
        return view('usuarios.show', compact('usuario', 'prestamosActivos', 'historialPrestamos'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'codigo_estudiante' => [
                'nullable', 'string', 'max:20',
                Rule::unique('usuarios')->ignore($usuario->id)
            ],
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => [
                'required', 'email', 'max:150',
                Rule::unique('usuarios')->ignore($usuario->id)
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'tipo_usuario' => 'required|in:estudiante,profesor,bibliotecario,admin',
            'estado' => 'required|in:activo,suspendido,inactivo',
            'multa_pendiente' => 'nullable|numeric|min:0'
        ]);
        
        $usuario->update($validated);
        
        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function bloquear(Usuario $usuario)
    {
        if ($usuario->tipo_usuario === 'admin') {
            return redirect()->back()->with('error', 'No se puede bloquear un administrador.');
        }
        
        $usuario->update(['estado' => 'suspendido']);
        
        return redirect()->back()->with('success', 'Usuario bloqueado exitosamente.');
    }
    
    public function activar(Usuario $usuario)
    {
        $usuario->update(['estado' => 'activo']);
        
        return redirect()->back()->with('success', 'Usuario activado exitosamente.');
    }
    
    public function destroy(Usuario $usuario)
    {
        if ($usuario->tipo_usuario === 'admin') {
            return redirect()->route('usuarios.index')
                ->with('error', 'No se puede eliminar un administrador.');
        }
        
        if ($usuario->prestamos()->activos()->exists()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No se puede eliminar un usuario con préstamos activos.');
        }
        
        $usuario->delete();
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
