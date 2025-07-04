@extends('layouts.app')

@section('title', 'Nuevo Préstamo')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Nuevo Préstamo</h1>
            <p class="page-subtitle">Registra un nuevo préstamo de libro</p>
        </div>
        <a href="{{ route('prestamos.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('prestamos.store') }}">
            @csrf
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Usuario *</label>
                    <select name="usuario_id" class="form-control" required>
                        <option value="">Seleccionar usuario...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre_completo }} - {{ $usuario->codigo_estudiante ?? $usuario->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('usuario_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Libro *</label>
                    <select name="libro_id" class="form-control" required>
                        <option value="">Seleccionar libro...</option>
                        @foreach($libros as $libro)
                            <option value="{{ $libro->id }}" {{ old('libro_id') == $libro->id ? 'selected' : '' }}>
                                {{ $libro->titulo }} - {{ $libro->autor->nombre_completo ?? 'Sin autor' }} (Disponibles: {{ $libro->cantidad_disponible }})
                            </option>
                        @endforeach
                    </select>
                    @error('libro_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Días de Préstamo *</label>
                <select name="dias_prestamo" class="form-control" required>
                    <option value="7" {{ old('dias_prestamo') == '7' ? 'selected' : '' }}>7 días</option>
                    <option value="14" {{ old('dias_prestamo', '14') == '14' ? 'selected' : '' }}>14 días</option>
                    <option value="21" {{ old('dias_prestamo') == '21' ? 'selected' : '' }}>21 días</option>
                    <option value="30" {{ old('dias_prestamo') == '30' ? 'selected' : '' }}>30 días</option>
                </select>
                @error('dias_prestamo')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Registrar Préstamo
                </button>
                <a href="{{ route('prestamos.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection