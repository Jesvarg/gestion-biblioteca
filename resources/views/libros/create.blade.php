@extends('layouts.app')

@section('title', 'Nuevo Libro')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Nuevo Libro</h1>
            <p class="page-subtitle">Registra un nuevo libro en el catálogo</p>
        </div>
        <a href="{{ route('libros.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('libros.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label for="titulo" class="form-label required">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                           value="{{ old('titulo') }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="form-control @error('isbn') is-invalid @enderror" 
                           value="{{ old('isbn') }}" placeholder="978-84-376-0494-7">
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
                        @foreach($autores as $autor)
                            <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>
                                {{ $autor->nombre_completo }}
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
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                          rows="4" placeholder="Descripción del libro...">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="grid grid-3 gap-4">
                <div class="form-group">
                    <label for="editorial" class="form-label">Editorial</label>
                    <input type="text" id="editorial" name="editorial" class="form-control @error('editorial') is-invalid @enderror" 
                           value="{{ old('editorial') }}">
                    @error('editorial')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="año_publicacion" class="form-label">Año de Publicación</label>
                    <input type="number" id="año_publicacion" name="año_publicacion" 
                           class="form-control @error('año_publicacion') is-invalid @enderror" 
                           value="{{ old('año_publicacion') }}" min="1000" max="{{ date('Y') }}">
                    @error('año_publicacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="numero_paginas" class="form-label">Número de Páginas</label>
                    <input type="number" id="numero_paginas" name="numero_paginas" 
                           class="form-control @error('numero_paginas') is-invalid @enderror" 
                           value="{{ old('numero_paginas') }}" min="1">
                    @error('numero_paginas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label for="cantidad_total" class="form-label required">Cantidad Total</label>
                    <input type="number" id="cantidad_total" name="cantidad_total" 
                           class="form-control @error('cantidad_total') is-invalid @enderror" 
                           value="{{ old('cantidad_total', 1) }}" min="1" required>
                    @error('cantidad_total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="ubicacion" class="form-label">Ubicación</label>
                    <input type="text" id="ubicacion" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" 
                           value="{{ old('ubicacion') }}" placeholder="Ej: Estante A-1">
                    @error('ubicacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="imagen_portada" class="form-label">Imagen de Portada</label>
                <input type="file" id="imagen_portada" name="imagen_portada" 
                       class="form-control @error('imagen_portada') is-invalid @enderror" 
                       accept="image/">
                @error('imagen_portada')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Guardar Libro
                </button>
                <a href="{{ route('libros.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Validación del formulario
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Preview de imagen
document.getElementById('imagen_portada').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Crear preview si no existe
            let preview = document.getElementById('image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'image-preview';
                preview.style.cssText = 'max-width: 200px; max-height: 200px; margin-top: 10px; border-radius: 8px;';
                e.target.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
