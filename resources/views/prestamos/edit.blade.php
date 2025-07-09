@extends('layouts.app')

@section('title', 'Editar Préstamo')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Editar Préstamo #{{ $prestamo->id }}</h1>
            <p class="page-subtitle">Modificar información del préstamo</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('prestamos.update', $prestamo) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" value="{{ $prestamo->usuario->nombre_completo }}" readonly>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Libro</label>
                    <input type="text" class="form-control" value="{{ $prestamo->libro->titulo }}" readonly>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Fecha de Devolución Esperada</label>
                    <input type="date" name="fecha_devolucion_esperada" class="form-control" 
                           value="{{ $prestamo->fecha_devolucion_esperada->format('Y-m-d') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="activo" {{ $prestamo->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="vencido" {{ $prestamo->estado === 'vencido' ? 'selected' : '' }}>Vencido</option>
                        <option value="devuelto" {{ $prestamo->estado === 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control">{{ $prestamo->observaciones }}</textarea>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Actualizar Préstamo
                </button>
                <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-outline">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection