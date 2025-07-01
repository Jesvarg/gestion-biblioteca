<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Libros destacados (más prestados)
        $librosDestacados = Libro::withCount('prestamos')
            ->with(['autor', 'categoria'])
            ->where('estado', 'activo')
            ->where('cantidad_disponible', '>', 0)
            ->orderBy('prestamos_count', 'desc')
            ->take(8)
            ->get();
        
        // Libros recientes
        $librosRecientes = Libro::with(['autor', 'categoria'])
            ->where('estado', 'activo')
            ->where('cantidad_disponible', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        // Categorías
        $categorias = Categoria::withCount('libros')
            ->orderBy('nombre')
            ->get();
        
        // Estadísticas generales
        $totalLibros = Libro::where('estado', 'activo')->count();
        $totalCategorias = Categoria::count();
        
        return view('home', compact(
            'librosDestacados',
            'librosRecientes', 
            'categorias',
            'totalLibros',
            'totalCategorias'
        ));
    }
}