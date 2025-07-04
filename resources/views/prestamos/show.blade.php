@extends('layouts.app')

@section('title', 'Detalle del Préstamo')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Detalle del Préstamo #{{ $prestamo->id }}</h1>
            <p class="page-subtitle">Información completa del préstamo</p>
        </div>
        <div class="flex gap-2">
            @if($prestamo->estado === 'activo')
                <form method="POST" action="{{ route('prestamos.devolver', $prestamo) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success" onclick="return confirm('¿Confirmar devolución?')">
                        <i class="fas fa-check"></i>
                        Marcar como Devuelto
                    </button>
                </form>
                
                @if(!$prestamo->estaVencido())
                    <form method="POST" action="{{ route('prestamos.renovar', $prestamo) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning" onclick="return confirm('¿Renovar préstamo por 7 días más?')">
                            <i class="fas fa-redo"></i>
                            Renovar
                        </button>
                    </form>
                @endif
            @endif
            
            <a href="{{ route('prestamos.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>
        </div>
    </div>
</div>

<div class="grid grid-2 gap-6">
    <!-- Información del Préstamo -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información del Préstamo</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Estado</label>
                    <div>
                        @if($prestamo->estado === 'activo')
                            @if(method_exists($prestamo, 'estaVencido') && $prestamo->estaVencido())
                                <span class="badge badge-danger">Vencido</span>
                            @else
                                <span class="badge badge-success">Activo</span>
                            @endif
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($prestamo->estado) }}</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="form-label">Fecha de Préstamo</label>
                    <div>{{ $prestamo->fecha_prestamo->format('d/m/Y H:i') }}</div>
                </div>
                
                <div>
                    <label class="form-label">Fecha de Devolución Esperada</label>
                    <div>{{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</div>
                </div>
                
                @if($prestamo->fecha_devolucion_real)
                    <div>
                        <label class="form-label">Fecha de Devolución Real</label>
                        <div>{{ $prestamo->fecha_devolucion_real->format('d/m/Y H:i') }}</div>
                    </div>
                @endif
                
                @if($prestamo->multa > 0)
                    <div>
                        <label class="form-label">Multa</label>
                        <div class="text-danger">${{ number_format($prestamo->multa, 2) }}</div>
                    </div>
                @endif
                
                @if($prestamo->observaciones)
                    <div>
                        <label class="form-label">Observaciones</label>
                        <div>{{ $prestamo->observaciones }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Información del Usuario -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuario</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nombre Completo</label>
                    <div>{{ $prestamo->usuario->nombre_completo }}</div>
                </div>
                
                <div>
                    <label class="form-label">Email</label>
                    <div>{{ $prestamo->usuario->email }}</div>
                </div>
                
                @if($prestamo->usuario->codigo_estudiante)
                    <div>
                        <label class="form-label">Código de Estudiante</label>
                        <div>{{ $prestamo->usuario->codigo_estudiante }}</div>
                    </div>
                @endif
                
                <div>
                    <label class="form-label">Tipo de Usuario</label>
                    <div>{{ ucfirst($prestamo->usuario->tipo_usuario) }}</div>
                </div>
                
                @if($prestamo->usuario->multa_pendiente > 0)
                    <div>
                        <label class="form-label">Multa Pendiente</label>
                        <div class="text-danger">${{ number_format($prestamo->usuario->multa_pendiente, 2) }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Información del Libro -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Libro</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                <div>
                    <label class="form-label">Título</label>
                    <div>{{ $prestamo->libro->titulo }}</div>
                </div>
                
                @if($prestamo->libro->autor)
                    <div>
                        <label class="form-label">Autor</label>
                        <div>{{ $prestamo->libro->autor->nombre_completo }}</div>
                    </div>
                @endif
                
                @if($prestamo->libro->isbn)
                    <div>
                        <label class="form-label">ISBN</label>
                        <div>{{ $prestamo->libro->isbn }}</div>
                    </div>
                @endif
                
                <div>
                    <label class="form-label">Disponibilidad</label>
                    <div>{{ $prestamo->libro->cantidad_disponible }}/{{ $prestamo->libro->cantidad_total }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información del Bibliotecario -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bibliotecarios</h3>
        </div>
        <div class="card-body">
            <div class="space-y-4">
                @if($prestamo->bibliotecarioPrestamo)
                    <div>
                        <label class="form-label">Registrado por</label>
                        <div>{{ $prestamo->bibliotecarioPrestamo->nombre_completo ?? 'Sistema' }}</div>
                    </div>
                @endif
                
                @if($prestamo->bibliotecarioDevolucion)
                    <div>
                        <label class="form-label">Devolución registrada por</label>
                        <div>{{ $prestamo->bibliotecarioDevolucion->nombre_completo ?? 'Sistema' }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection