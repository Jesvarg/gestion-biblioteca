@extends('layouts.app')

@section('title', 'Editar Libro')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Editar Libro</h1>
            <p class="page-subtitle">Modifica la información del libro</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('libros.show', $libro) }}" class="btn btn-outline">
                <i class="fas fa-eye"></i>
                Ver
            </a>
            <a href="{{ route('libros.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('libros.update', $libro) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label for="titulo" class="form-label required">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                           value="{{ old('titulo', $libro->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="form-control @error('isbn') is-invalid @enderror" 
                           value="{{ old('isbn', $libro->isbn) }}" placeholder="978-84-376-0494-7">
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label for="autor_id" class="form-label required">Autor</label>
                    <select id="autor_id" name="autor_id" class="form-control @error('autor_id') is-invalid @enderror" required>
                        <option value="">Seleccionar autor</option>
                        @foreach($autores ?? [] as $autor)
                            <option value="{{ $autor->id }}" {{ old('autor_id', $libro->autor_id) == $autor->id ? 'selected' : '' }}>
                                {{ $autor->nombre }} {{ $autor->apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('autor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="categoria_id" class="form-label required">Categoría</label>
                    <select id="categoria_id" name="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                        <option value="">Seleccionar categoría</option>
                        @foreach($categorias ?? [] as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $libro->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-3 gap-4">
                <div class="form-group">
                    <label for="editorial" class="form-label">Editorial</label>
                    <input type="text" id="editorial" name="editorial" class="form-control @error('editorial') is-invalid @enderror" 
                           value="{{ old('editorial', $libro->editorial) }}">
                    @error('editorial')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="año_publicacion" class="form-label">Año de Publicación</label>
                    <input type="number" id="año_publicacion" name="año_publicacion" class="form-control @error('año_publicacion') is-invalid @enderror" 
                           value="{{ old('año_publicacion', $libro->año_publicacion) }}" min="1000" max="{{ date('Y') }}">
                    @error('año_publicacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="numero_paginas" class="form-label">Número de Páginas</label>
                    <input type="number" id="numero_paginas" name="numero_paginas" class="form-control @error('numero_paginas') is-invalid @enderror" 
                           value="{{ old('numero_paginas', $libro->numero_paginas) }}" min="1">
                    @error('numero_paginas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label for="cantidad_total" class="form-label required">Cantidad Total</label>
                    <input type="number" id="cantidad_total" name="cantidad_total" class="form-control @error('cantidad_total') is-invalid @enderror" 
                           value="{{ old('cantidad_total', $libro->cantidad_total) }}" min="1" required>
                    @error('cantidad_total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="cantidad_disponible" class="form-label required">Cantidad Disponible</label>
                    <input type="number" id="cantidad_disponible" name="cantidad_disponible" class="form-control @error('cantidad_disponible') is-invalid @enderror" 
                           value="{{ old('cantidad_disponible', $libro->cantidad_disponible) }}" min="0" required>
                    @error('cantidad_disponible')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" 
                       value="{{ old('ubicacion', $libro->ubicacion) }}" placeholder="Ej: Estante A, Nivel 2">
                @error('ubicacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                          rows="4" placeholder="Descripción del libro...">{{ old('descripcion', $libro->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="imagen_portada" class="form-label">Imagen de Portada</label>
                <input type="file" id="imagen_portada" name="imagen_portada" class="form-control @error('imagen_portada') is-invalid @enderror" 
                       accept="image/*">
                @if($libro->imagen_portada)
                    <div class="mt-2">
                        <img src="{{ $libro->imagen_portada }}" alt="Portada actual" style="max-width: 200px; height: auto;">
                        <p class="text-sm text-secondary">Imagen actual</p>
                    </div>
                @endif
                @error('imagen_portada')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Actualizar Libro
                </button>
                <a href="{{ route('libros.show', $libro) }}" class="btn btn-outline">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection