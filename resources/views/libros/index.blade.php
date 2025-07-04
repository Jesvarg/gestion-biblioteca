@extends('layouts.app')

@section('title', 'Gestión de Libros')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Gestión de Libros</h1>
            <p class="page-subtitle">Administra el catálogo de la biblioteca</p>
        </div>
        <a href="{{ route('libros.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Libro
        </a>
    </div>
</div>

<!-- Filtros de búsqueda -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('libros.index') }}" class="grid grid-4 gap-4">
            <div class="form-group">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por título, autor o ISBN..." value="{{ request('buscar') }}">
            </div>
            
            <div class="form-group">
                <select name="categoria" class="form-control">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <select name="disponibles" class="form-control">
                    <option value="">Todos los estados</option>
                    <option value="1" {{ request('disponibles') == '1' ? 'selected' : '' }}>Solo disponibles</option>
                    <option value="0" {{ request('disponibles') == '0' ? 'selected' : '' }}>Solo prestados</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Lista de libros -->
<div class="grid grid-3">
    @forelse($libros as $libro)
        <div class="card fade-in">
            @if($libro->imagen_portada)
                <div style="height: 200px; background-image: url('{{ Storage::url($libro->imagen_portada) }}'); background-size: cover; background-position: center;"></div>
            @else
                <div style="height: 200px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book" style="font-size: 3rem; color: white; opacity: 0.7;"></i>
                </div>
            @endif
            
            <div class="card-body">
                <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; line-height: 1.4;">{{ $libro->titulo }}</h3>
                
                <p class="text-sm" style="color: var(--secondary); margin-bottom: 0.5rem;">
                    <i class="fas fa-user"></i>
                    {{ $libro->autor->nombre_completo ?? 'Sin autor' }}
                </p>
                
                <p class="text-sm" style="color: var(--secondary); margin-bottom: 0.5rem;">
                    <i class="fas fa-tag"></i>
                    {{ $libro->categoria->nombre ?? 'Sin categoría' }}
                </p>
                
                @if($libro->isbn)
                    <p class="text-sm" style="color: var(--secondary); margin-bottom: 1rem;">
                        <i class="fas fa-barcode"></i>
                        {{ $libro->isbn }}
                    </p>
                @endif
                
                <div class="flex items-center justify-between mb-4">
                    <div>
                        @if($libro->estaDisponible())
                            <span style="background: var(--success); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                <i class="fas fa-check"></i> Disponible
                            </span>
                        @else
                            <span style="background: var(--danger); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                <i class="fas fa-times"></i> No disponible
                            </span>
                        @endif
                    </div>
                    <div class="text-sm" style="color: var(--secondary);">
                        {{ $libro->cantidad_disponible }}/{{ $libro->cantidad_total }}
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('libros.show', $libro) }}" class="btn btn-outline btn-hover" style="flex: 1; font-size: 0.875rem;">
                        <i class="fas fa-eye"></i>
                        Ver
                    </a>
                    <a href="{{ route('libros.edit', $libro) }}" class="btn btn-secondary btn-hover" style="flex: 1; font-size: 0.875rem;">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1;">
            <div class="card">
                <div class="card-body text-center" style="padding: 3rem;">
                    <i class="fas fa-book" style="font-size: 4rem; color: var(--secondary); opacity: 0.5; margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--secondary); margin-bottom: 1rem;">No se encontraron libros</h3>
                    <p style="color: var(--secondary); margin-bottom: 2rem;">No hay libros que coincidan con los criterios de búsqueda.</p>
                    <a href="{{ route('libros.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Registrar Primer Libro
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Paginación -->
@if($libros->hasPages())
    <div class="mt-4">
        {{ $libros->links() }}
    </div>
@endif
@endsection

@push('styles')
<style>
    .btn-hover {
        transition: all 0.3s ease;
        transform: translateY(0);
    }
    
    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-outline.btn-hover:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .btn-secondary.btn-hover:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }
    
    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border);
        border-radius: 6px;
        text-decoration: none;
        color: var(--secondary);
        transition: all 0.2s;
    }
    
    .pagination a:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .pagination .active span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
</style>
@endpush