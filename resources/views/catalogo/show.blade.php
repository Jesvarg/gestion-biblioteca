@extends('layouts.public')

@section('title', $libro->titulo)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('catalogo.index') }}" class="hover:text-blue-600">Catálogo</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-800">{{ $libro->titulo }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
            <!-- Imagen del libro -->
            <div class="lg:col-span-1">
                <div class="aspect-w-3 aspect-h-4 bg-gray-200 rounded-lg overflow-hidden">
                    @if($libro->imagen_portada)
                        <img src="{{ Storage::url($libro->imagen_portada) }}" 
                             alt="{{ $libro->titulo }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <i class="fas fa-book text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del libro -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $libro->titulo }}</h1>
                    <p class="text-xl text-gray-600 mb-4">por {{ $libro->autor->nombre_completo ?? 'Autor desconocido' }}</p>
                    
                    @if($libro->cantidad_disponible > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Disponible
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            No disponible
                        </span>
                    @endif
                </div>

                @if($libro->descripcion)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Descripción</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $libro->descripcion }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Información básica</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Autor</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->autor->nombre_completo ?? 'Sin autor' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Categoría</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->categoria->nombre ?? 'Sin categoría' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Editorial</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->editorial ?: 'No especificada' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">ISBN</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->isbn ?: 'No disponible' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalles adicionales</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Año de publicación</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->año_publicacion ?: 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Número de páginas</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->numero_paginas ?: 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Ubicación</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->ubicacion ?: 'No especificada' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Disponibles</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->cantidad_disponible }} de {{ $libro->cantidad_total }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Libros relacionados -->
    @if($librosRelacionados->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Libros relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($librosRelacionados as $libroRelacionado)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="aspect-w-3 aspect-h-4 bg-gray-200">
                            @if($libroRelacionado->imagen_portada)
                                <img src="{{ Storage::url($libroRelacionado->imagen_portada) }}" 
                                     alt="{{ $libroRelacionado->titulo }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <i class="fas fa-book text-4xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $libroRelacionado->titulo }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $libroRelacionado->autor->nombre_completo ?? 'Sin autor' }}</p>
                            <a href="{{ route('catalogo.libro', $libroRelacionado) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection