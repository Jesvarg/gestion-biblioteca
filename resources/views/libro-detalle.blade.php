@extends('layouts.public')

@section('title', $libro->titulo)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('catalogo.publico') }}" class="hover:text-blue-600">Catálogo</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-800">{{ $libro->titulo }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
            <!-- Imagen del libro -->
            <div class="lg:col-span-1">
                <div class="aspect-w-3 aspect-h-4 bg-gray-200 rounded-lg overflow-hidden">
                    @if($libro->imagen)
                        <img src="{{ asset('storage/libros/' . $libro->imagen) }}" 
                             alt="{{ $libro->titulo }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-96">
                            <i class="fas fa-book text-8xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del libro -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $libro->titulo }}</h1>
                    
                    <!-- Estado -->
                    <div class="mb-4">
                        @if($libro->estado == 'disponible')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Disponible
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-2"></i>
                                Prestado
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Detalles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Información del libro</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Autor</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->autor->nombre }} {{ $libro->autor->apellido }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Categoría</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->categoria->nombre }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Editorial</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->editorial }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">ISBN</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->isbn }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalles adicionales</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Fecha de publicación</dt>
                                <dd class="text-sm text-gray-800">
                                    {{ $libro->fecha_publicacion ? $libro->fecha_publicacion->format('d/m/Y') : 'No disponible' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Número de páginas</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->numero_paginas ?? 'No disponible' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Ubicación</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->ubicacion }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600">Nacionalidad del autor</dt>
                                <dd class="text-sm text-gray-800">{{ $libro->autor->nacionalidad }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Descripción -->
                @if($libro->descripcion)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Descripción</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $libro->descripcion }}</p>
                    </div>
                @endif

                <!-- Biografía del autor -->
                @if($libro->autor->biografia)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Sobre el autor</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $libro->autor->biografia }}</p>
                    </div>
                @endif

                <!-- Acciones -->
                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        @if($libro->estado == 'disponible')
                            <button class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition duration-200 flex items-center justify-center">
                                <i class="fas fa-book-reader mr-2"></i>
                                Solicitar préstamo
                            </button>
                        @else
                            <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-md cursor-not-allowed flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i>
                                No disponible
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Inicia sesión para solicitar
                        </a>
                    @endauth
                    
                    <a href="{{ route('catalogo.publico') }}" 
                       class="bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Libros relacionados -->
    @if($librosRelacionados->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Libros relacionados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($librosRelacionados as $relacionado)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="h-32 bg-gray-200 flex items-center justify-center">
                            @if($relacionado->imagen)
                                <img src="{{ asset('storage/libros/' . $relacionado->imagen) }}" 
                                     alt="{{ $relacionado->titulo }}"
                                     class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-book text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $relacionado->titulo }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $relacionado->autor->nombre }} {{ $relacionado->autor->apellido }}</p>
                            <a href="{{ route('libro.publico', $relacionado->id) }}" 
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