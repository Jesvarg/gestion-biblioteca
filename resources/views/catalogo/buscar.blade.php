@extends('layouts.public')

@section('title', 'Resultados de búsqueda')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Resultados de búsqueda</h1>
        <p class="text-gray-600">Resultados para: <strong>"{{ $termino }}"</strong></p>
        <p class="text-sm text-gray-500">{{ $libros->total() }} libro(s) encontrado(s)</p>
    </div>

    @if($libros->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($libros as $libro)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="aspect-w-3 aspect-h-4 bg-gray-200">
                        @if($libro->imagen_portada)
                            <img src="{{ Storage::url($libro->imagen_portada) }}" 
                                 alt="{{ $libro->titulo }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <i class="fas fa-book text-4xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $libro->titulo }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $libro->autor->nombre_completo ?? 'Sin autor' }}</p>
                        <p class="text-xs text-gray-500 mb-3">{{ $libro->categoria->nombre ?? 'Sin categoría' }}</p>
                        
                        @if($libro->cantidad_disponible > 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-3">
                                <i class="fas fa-check-circle mr-1"></i>
                                Disponible
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mb-3">
                                <i class="fas fa-times-circle mr-1"></i>
                                No disponible
                            </span>
                        @endif
                        
                        <a href="{{ route('catalogo.libro', $libro) }}" 
                           class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors text-sm">
                            Ver detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $libros->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No se encontraron resultados</h3>
            <p class="text-gray-500 mb-6">Intenta con otros términos de búsqueda</p>
            <a href="{{ route('catalogo.index') }}" class="btn btn-primary">
                Ver todo el catálogo
            </a>
        </div>
    @endif
</div>
@endsection