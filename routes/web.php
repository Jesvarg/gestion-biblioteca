<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;

// Página principal pública (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo público
Route::prefix('catalogo')->name('catalogo.')->group(function () {
    Route::get('/', [LibroController::class, 'catalogo'])->name('index');
    Route::get('/libro/{libro}', [LibroController::class, 'mostrarPublico'])->name('libro');
    Route::get('/buscar', [LibroController::class, 'buscarPublico'])->name('buscar');
});

// Rutas protegidas para administradores
Route::middleware(['auth', 'bibliotecario'])->group(function () {
    // Dashboard (solo administradores)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de libros (administradores)
    Route::resource('libros', LibroController::class);
    Route::get('/libros/{libro}/disponibilidad', [LibroController::class, 'disponibilidad'])
        ->name('libros.disponibilidad');
    
    // Gestión de usuarios
    Route::resource('usuarios', UsuarioController::class);
    Route::patch('/usuarios/{usuario}/bloquear', [UsuarioController::class, 'bloquear'])
        ->name('usuarios.bloquear');
    Route::patch('/usuarios/{usuario}/activar', [UsuarioController::class, 'activar'])
        ->name('usuarios.activar');
    Route::patch('/usuarios/{usuario}/multa', [UsuarioController::class, 'pagarMulta'])
        ->name('usuarios.pagar-multa');
    
    // Préstamos
    Route::resource('prestamos', PrestamoController::class);
    Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])
        ->name('prestamos.devolver');
    Route::patch('/prestamos/{prestamo}/renovar', [PrestamoController::class, 'renovar'])
        ->name('prestamos.renovar');
    
    // Autores
    Route::resource('autores', AutorController::class);
    
    // Categorías
    Route::resource('categorias', CategoriaController::class);
    
    // API para búsquedas AJAX
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/usuarios/buscar', [UsuarioController::class, 'buscarAjax'])
            ->name('usuarios.buscar');
        Route::get('/libros/buscar', [LibroController::class, 'buscarAjax'])
            ->name('libros.buscar');
    });
});

// Rutas para usuarios autenticados (no administradores)
Route::middleware(['auth'])->group(function () {
    Route::get('/mi-perfil', [UsuarioController::class, 'perfil'])->name('perfil');
    Route::patch('/mi-perfil', [UsuarioController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::get('/mis-prestamos', [PrestamoController::class, 'misPrestamos'])->name('mis-prestamos');
    Route::post('/solicitar-prestamo/{libro}', [PrestamoController::class, 'solicitarPrestamo'])->name('solicitar-prestamo');
});

require __DIR__.'/auth.php';