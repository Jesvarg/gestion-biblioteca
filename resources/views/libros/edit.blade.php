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
            
            <!-- Resto del formulario igual que create.blade.php pero con valores del $libro -->
            <!-- ... existing code ... -->
            
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