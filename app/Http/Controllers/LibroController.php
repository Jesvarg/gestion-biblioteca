<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
    public function index(Request $request)
    {
        $query = Libro::with(['autor', 'categoria']);
        
        if ($request->has('buscar') && $request->buscar) {
            $query->buscar($request->buscar);
        }
        
        if ($request->has('categoria') && $request->categoria) {
            $query->where('categoria_id', $request->categoria);
        }
        
        if ($request->has('disponibles') && $request->disponibles) {
            $query->disponibles();
        }
        
        $libros = $query->paginate(12);
        $categorias = Categoria::all();
        
        return view('libros.index', compact('libros', 'categorias'));
    }

    public function create()
    {
        $autores = Autor::orderBy('apellido')->get();
        $categorias = Categoria::all();
        
        return view('libros.create', compact('autores', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:libros',
            'autor_id' => 'required|exists:autores,id',
            'categoria_id' => 'required|exists:categorias,id',
            'editorial' => 'nullable|string|max:150',
            'año_publicacion' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'cantidad_total' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('imagen_portada')) {
            $validated['imagen_portada'] = $request->file('imagen_portada')
                ->store('portadas', 'public');
        }
        
        $validated['cantidad_disponible'] = $validated['cantidad_total'];
        
        $libro = Libro::create($validated);
        
        return redirect()->route('libros.show', $libro)
            ->with('success', 'Libro registrado exitosamente.');
    }

    public function show(Libro $libro)
    {
        $libro->load(['autor', 'categoria', 'prestamos.usuario']);
        
        return view('libros.show', compact('libro'));
    }

    public function edit(Libro $libro)
    {
        $autores = Autor::orderBy('apellido')->get();
        $categorias = Categoria::all();
        
        return view('libros.edit', compact('libro', 'autores', 'categorias'));
    }

    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:libros,isbn,' . $libro->id,
            'autor_id' => 'required|exists:autores,id',
            'categoria_id' => 'required|exists:categorias,id',
            'editorial' => 'nullable|string|max:150',
            'año_publicacion' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'cantidad_total' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo,mantenimiento',
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('imagen_portada')) {
            if ($libro->imagen_portada) {
                Storage::disk('public')->delete($libro->imagen_portada);
            }
            $validated['imagen_portada'] = $request->file('imagen_portada')
                ->store('portadas', 'public');
        }
        
        // Ajustar cantidad disponible si cambió la cantidad total
        if ($validated['cantidad_total'] != $libro->cantidad_total) {
            $diferencia = $validated['cantidad_total'] - $libro->cantidad_total;
            $validated['cantidad_disponible'] = max(0, $libro->cantidad_disponible + $diferencia);
        }
        
        $libro->update($validated);
        
        return redirect()->route('libros.show', $libro)
            ->with('success', 'Libro actualizado exitosamente.');
    }

    public function destroy(Libro $libro)
    {
        if ($libro->prestamos()->where('estado', 'activo')->exists()) {
            return redirect()->route('libros.index')
                ->with('error', 'No se puede eliminar un libro con préstamos activos.');
        }
        
        if ($libro->imagen_portada) {
            Storage::disk('public')->delete($libro->imagen_portada);
        }
        
        $libro->delete();
        
        return redirect()->route('libros.index')
            ->with('success', 'Libro eliminado exitosamente.');
    }

    public function catalogo(Request $request)
    {
        $query = Libro::with(['autor', 'categoria'])
            ->where('estado', 'activo');
        
        if ($request->has('buscar') && $request->buscar) {
            $query->buscar($request->buscar);
        }
        
        if ($request->has('categoria') && $request->categoria) {
            $query->where('categoria_id', $request->categoria);
        }
        
        if ($request->has('disponibles') && $request->disponibles) {
            $query->disponibles();
        }
        
        $libros = $query->paginate(12);
        $categorias = Categoria::all();
        
        return view('catalogo.index', compact('libros', 'categorias'));
    }
    
    public function mostrarPublico(Libro $libro)
    {
        $libro->load(['autor', 'categoria']);
        
        // Libros relacionados (misma categoría)
        $librosRelacionados = Libro::where('categoria_id', $libro->categoria_id)
            ->where('id', '!=', $libro->id)
            ->where('estado', 'activo')
            ->with(['autor'])
            ->take(4)
            ->get();
        
        return view('catalogo.show', compact('libro', 'librosRelacionados'));
    }
    
    public function buscarPublico(Request $request)
    {
        $termino = $request->get('q');
        
        if (!$termino) {
            return redirect()->route('catalogo.index');
        }
        
        $libros = Libro::with(['autor', 'categoria'])
            ->where('estado', 'activo')
            ->buscar($termino)
            ->paginate(12);
        
        $categorias = Categoria::all();
        
        return view('catalogo.buscar', compact('libros', 'categorias', 'termino'));
    }
}