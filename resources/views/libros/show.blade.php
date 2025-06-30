@extends('layouts.app')

@section('title', $libro->titulo)

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">{{ $libro->titulo }}</h1>
            <p class="page-subtitle">Detalles del libro</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('libros.edit', $libro) }}" class="btn btn-secondary">
                <i class="fas fa-edit"></i>
                Editar
            </a>
            <a href="{{ route('libros.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>
        </div>
    </div>
</div>

<div class="grid grid-3 gap-6">
    <!-- Información principal -->
    <div class="col-span-2">
        <div class="card">
            <div class="card-header">
                <h3>Información del Libro</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-2 gap-4">
                    <div>
                        <label class="form-label">Título:</label>
                        <p class="font-medium">{{ $libro->titulo }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">ISBN:</label>
                        <p class="font-medium">{{ $libro->isbn ?: 'No especificado' }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">Autor:</label>
                        <p class="font-medium">{{ $libro->autor->nombre_completo ?? 'Sin autor' }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">Categoría:</label>
                        <p class="font-medium">{{ $libro->categoria->nombre ?? 'Sin categoría' }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">Editorial:</label>
                        <p class="font-medium">{{ $libro->editorial ?: 'No especificada' }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">Año de Publicación:</label>
                        <p class="font-medium">{{ $libro->año_publicacion ?: 'No especificado' }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">Número de Páginas:</label>
                        <p class="font-medium">{{ $libro->numero_paginas ?: 'No especificado' }}</p>
                    </div>
                    
                    <div>
                        <label class="form-label">Ubicación:</label>
                        <p class="font-medium">{{ $libro->ubicacion ?: 'No especificada' }}</p>
                    </div>
                </div>
                
                @if($libro->descripcion)
                    <div class="mt-4">
                        <label class="form-label">Descripción:</label>
                        <p class="text-gray-700">{{ $libro->descripcion }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Disponibilidad -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Disponibilidad</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $libro->cantidad_total }}</div>
                        <div class="text-sm text-gray-600">Total</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $libro->cantidad_disponible }}</div>
                        <div class="text-sm text-gray-600">Disponibles</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $libro->cantidad_total - $libro->cantidad_disponible }}</div>
                        <div class="text-sm text-gray-600">Prestados</div>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    @if($libro->estaDisponible())
                        <span class="badge badge-success">
                            <i class="fas fa-check"></i> Disponible para préstamo
                        </span>
                    @else
                        <span class="badge badge-danger">
                            <i class="fas fa-times"></i> No disponible
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Imagen y acciones -->
    <div>
        <div class="card">
            <div class="card-body text-center">
                @if($libro->imagen_portada)
                    <img src="{{ Storage::url($libro->imagen_portada) }}" alt="{{ $libro->titulo }}" 
                         class="w-full max-w-xs mx-auto rounded-lg shadow-md">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-4xl text-gray-400"></i>
                    </div>
                @endif
                
                <div class="mt-4 space-y-2">
                    @if($libro->estaDisponible())
                        <a href="{{ route('prestamos.create', ['libro' => $libro->id]) }}" class="btn btn-primary w-full">
                            <i class="fas fa-hand-holding"></i>
                            Crear Préstamo
                        </a>
                    @endif
                    
                    <a href="{{ route('libros.edit', $libro) }}" class="btn btn-secondary w-full">
                        <i class="fas fa-edit"></i>
                        Editar Libro
                    </a>
                    
                    <form action="{{ route('libros.destroy', $libro) }}" method="POST" class="inline w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full" 
                                onclick="return confirm('¿Estás seguro de eliminar este libro?')">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
