@extends('layouts.public')

@section('title', 'Catálogo de Libros')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Catálogo de Libros</h1>
        <p class="text-gray-600">Explora nuestra colección de libros disponibles</p>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('catalogo.publico') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label for="buscar" class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           id="buscar" 
                           name="buscar" 
                           value="{{ request('buscar') }}"
                           placeholder="Título, autor, ISBN..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Categoría -->
                <div>
                    <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select id="categoria" 
                            name="categoria" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" 
                                    {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Disponibilidad</label>
                    <select id="estado" 
                            name="estado" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="disponible" {{ request('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="prestado" {{ request('estado') == 'prestado' ? 'selected' : '' }}>Prestado</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                <a href="{{ route('catalogo.publico') }}" 
                   class="text-gray-600 hover:text-gray-800 transition duration-200">
                    <i class="fas fa-times mr-1"></i>Limpiar filtros
                </a>
            </div>
        </form>
    </div>

    <!-- Resultados -->
    @if($libros->count() > 0)
        <div class="mb-6">
            <p class="text-gray-600">
                Mostrando {{ $libros->firstItem() }} - {{ $libros->lastItem() }} de {{ $libros->total() }} libros
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($libros as $libro)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <!-- Imagen del libro -->
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($libro->imagen)
                            <img src="{{ asset('storage/libros/' . $libro->imagen) }}" 
                                 alt="{{ $libro->titulo }}"
                                 class="h-full w-full object-cover">
                        @else
                            <i class="fas fa-book text-4xl text-gray-400"></i>
                        @endif
                    </div>

                    <!-- Información del libro -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $libro->titulo }}</h3>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-user mr-1"></i>
                            {{ $libro->autor->nombre }} {{ $libro->autor->apellido }}
                        </p>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-tag mr-1"></i>
                            {{ $libro->categoria->nombre }}
                        </p>
                        <p class="text-gray-600 text-sm mb-3">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $libro->fecha_publicacion ? $libro->fecha_publicacion->format('Y') : 'N/A' }}
                        </p>

                        <!-- Estado -->
                        <div class="mb-3">
                            @if($libro->estado == 'disponible')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Prestado
                                </span>
                            @endif
                        </div>

                        <!-- Botón ver detalles -->
                        <a href="{{ route('libro.publico', $libro->id) }}" 
                           class="w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 inline-block">
                            <i class="fas fa-eye mr-2"></i>Ver detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $libros->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No se encontraron libros</h3>
            <p class="text-gray-500 mb-4">Intenta ajustar los filtros de búsqueda</p>
            <a href="{{ route('catalogo.publico') }}" 
               class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                Ver todos los libros
            </a>
        </div>
    @endif
</div>
@endsection