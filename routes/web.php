<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ReporteController;

// Página principal
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Libros
    Route::resource('libros', LibroController::class);
    Route::get('/libros/{libro}/disponibilidad', [LibroController::class, 'disponibilidad'])
        ->name('libros.disponibilidad');
    
    // Usuarios
    Route::resource('usuarios', UsuarioController::class);
    Route::patch('/usuarios/{usuario}/multa', [UsuarioController::class, 'pagarMulta'])
        ->name('usuarios.pagar-multa');
    
    // Préstamos
    Route::resource('prestamos', PrestamoController::class)->except(['edit', 'update', 'destroy']);
    Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])
        ->name('prestamos.devolver');
    Route::patch('/prestamos/{prestamo}/renovar', [PrestamoController::class, 'renovar'])
        ->name('prestamos.renovar');
    
    // Autores
    Route::resource('autores', AutorController::class);
    
    // Categorías
    Route::resource('categorias', CategoriaController::class);
    
    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/prestamos-vencidos', [ReporteController::class, 'prestamosVencidos'])
            ->name('prestamos-vencidos');
        Route::get('/libros-populares', [ReporteController::class, 'librosPopulares'])
            ->name('libros-populares');
        Route::get('/usuarios-morosos', [ReporteController::class, 'usuariosMorosos'])
            ->name('usuarios-morosos');
        Route::get('/estadisticas', [ReporteController::class, 'estadisticas'])
            ->name('estadisticas');
    });
    
    // API para búsquedas AJAX
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/usuarios/buscar', [UsuarioController::class, 'buscarAjax'])
            ->name('usuarios.buscar');
        Route::get('/libros/buscar', [LibroController::class, 'buscarAjax'])
            ->name('libros.buscar');
    });
});

// Rutas públicas (catálogo)
Route::prefix('catalogo')->name('catalogo.')->group(function () {
    Route::get('/', [LibroController::class, 'catalogo'])->name('index');
    Route::get('/libro/{libro}', [LibroController::class, 'mostrarPublico'])
        ->name('libro');
    Route::get('/buscar', [LibroController::class, 'buscarPublico'])
        ->name('buscar');
});

