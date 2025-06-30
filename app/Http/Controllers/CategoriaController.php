<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('libros')->orderBy('nombre')->paginate(15);
        
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias',
            'descripcion' => 'nullable|string'
        ]);
        
        $categoria = Categoria::create($validated);
        
        return redirect()->route('categorias.show', $categoria)
            ->with('success', 'Categoría registrada exitosamente.');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['libros.autor']);
        
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string'
        ]);
        
        $categoria->update($validated);
        
        return redirect()->route('categorias.show', $categoria)
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->libros()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar una categoría que tiene libros asociados.');
        }
        
        $categoria->delete();
        
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
