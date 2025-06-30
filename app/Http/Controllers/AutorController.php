<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index(Request $request)
    {
        $query = Autor::withCount('libros');
        
        if ($request->has('buscar') && $request->buscar) {
            $termino = $request->buscar;
            $query->where(function($q) use ($termino) {
                $q->where('nombre', 'LIKE', "%{$termino}%")
                  ->orWhere('apellido', 'LIKE', "%{$termino}%")
                  ->orWhere('nacionalidad', 'LIKE', "%{$termino}%");
            });
        }
        
        $autores = $query->orderBy('apellido')->paginate(15);
        
        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'biografia' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'nacionalidad' => 'nullable|string|max:100'
        ]);
        
        $autor = Autor::create($validated);
        
        return redirect()->route('autores.show', $autor)
            ->with('success', 'Autor registrado exitosamente.');
    }

    public function show(Autor $autor)
    {
        $autor->load(['libros.categoria']);
        
        return view('autores.show', compact('autor'));
    }

    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    public function update(Request $request, Autor $autor)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'biografia' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'nacionalidad' => 'nullable|string|max:100'
        ]);
        
        $autor->update($validated);
        
        return redirect()->route('autores.show', $autor)
            ->with('success', 'Autor actualizado exitosamente.');
    }

    public function destroy(Autor $autor)
    {
        if ($autor->libros()->count() > 0) {
            return redirect()->route('autores.index')
                ->with('error', 'No se puede eliminar un autor que tiene libros asociados.');
        }
        
        $autor->delete();
        
        return redirect()->route('autores.index')
            ->with('success', 'Autor eliminado exitosamente.');
    }
}
