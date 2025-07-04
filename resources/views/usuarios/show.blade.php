@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">{{ $usuario->nombre_completo }}</h1>
            <p class="page-subtitle">Información detallada del usuario</p>
        </div>
        <div class="flex gap-2">
            @if($usuario->tipo_usuario !== 'admin')
                @if($usuario->estado === 'activo')
                    <form method="POST" action="{{ route('usuarios.bloquear', $usuario) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning" onclick="return confirm('¿Estás seguro de bloquear este usuario?')">
                            <i class="fas fa-ban"></i>
                            Bloquear
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('usuarios.activar', $usuario) }}" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Activar
                        </button>
                    </form>
                @endif
                
                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                        <i class="fas fa-trash"></i>
                        Eliminar
                    </button>
                </form>
            @endif
            
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-2 gap-4">
    <!-- Información personal -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información Personal</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-2 gap-4">
                <div>
                    <label class="form-label">Nombre Completo</label>
                    <p style="font-weight: 600;">{{ $usuario->nombre_completo }}</p>
                </div>
                
                <div>
                    <label class="form-label">Email</label>
                    <p>{{ $usuario->email }}</p>
                </div>
                
                <div>
                    <label class="form-label">Código de Estudiante</label>
                    <p>{{ $usuario->codigo_estudiante ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="form-label">Teléfono</label>
                    <p>{{ $usuario->telefono ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="form-label">Tipo de Usuario</label>
                    <span class="badge badge-{{ $usuario->tipo_usuario === 'admin' ? 'danger' : ($usuario->tipo_usuario === 'bibliotecario' ? 'warning' : 'primary') }}">
                        {{ ucfirst($usuario->tipo_usuario) }}
                    </span>
                </div>
                
                <div>
                    <label class="form-label">Estado</label>
                    <span class="badge badge-{{ $usuario->estado === 'activo' ? 'success' : 'danger' }}">
                        {{ ucfirst($usuario->estado) }}
                    </span>
                </div>
                
                <div>
                    <label class="form-label">Fecha de Registro</label>
                    <p>{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div>
                    <label class="form-label">Multa Pendiente</label>
                    <p style="color: {{ $usuario->multa_pendiente > 0 ? 'var(--danger)' : 'var(--success)' }}; font-weight: 600;">
                        ${{ number_format($usuario->multa_pendiente, 2) }}
                    </p>
                </div>
            </div>
            
            @if($usuario->direccion)
                <div class="mt-4">
                    <label class="form-label">Dirección</label>
                    <p>{{ $usuario->direccion }}</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Estadísticas de préstamos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Estadísticas de Préstamos</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-2 gap-4">
                <div class="text-center">
                    <div style="font-size: 2rem; color: var(--primary); margin-bottom: 0.5rem;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $prestamosActivos->count() }}</h3>
                    <p class="text-sm" style="color: var(--secondary);">Préstamos Activos</p>
                </div>
                
                <div class="text-center">
                    <div style="font-size: 2rem; color: var(--success); margin-bottom: 0.5rem;">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $usuario->prestamos->count() }}</h3>
                    <p class="text-sm" style="color: var(--secondary);">Total Préstamos</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Préstamos activos -->
@if($prestamosActivos->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Préstamos Activos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Vencimiento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamosActivos as $prestamo)
                        <tr>
                            <td>
                                <div>
                                    <div style="font-weight: 600;">{{ $prestamo->libro->titulo }}</div>
                                    <div class="text-sm" style="color: var(--secondary);">{{ $prestamo->libro->autor->nombre_completo ?? 'Sin autor' }}</div>
                                </div>
                            </td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td>{{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td>
                                @if($prestamo->fecha_vencimiento < now())
                                    <span class="badge badge-danger">Vencido</span>
                                @else
                                    <span class="badge badge-success">Activo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-sm btn-outline">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Historial de préstamos -->
@if($historialPrestamos->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Historial de Préstamos (Últimos 10)</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Devolución</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historialPrestamos as $prestamo)
                        <tr>
                            <td>
                                <div>
                                    <div style="font-weight: 600;">{{ $prestamo->libro->titulo }}</div>
                                    <div class="text-sm" style="color: var(--secondary);">{{ $prestamo->libro->autor->nombre_completo ?? 'Sin autor' }}</div>
                                </div>
                            </td>
                            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                            <td>{{ $prestamo->fecha_devolucion ? $prestamo->fecha_devolucion->format('d/m/Y') : 'Pendiente' }}</td>
                            <td>
                                <span class="badge badge-{{ $prestamo->estado === 'devuelto' ? 'success' : ($prestamo->estado === 'activo' ? 'primary' : 'secondary') }}">
                                    {{ ucfirst($prestamo->estado) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($usuario->prestamos->count() > 10)
            <div class="text-center mt-4">
                <a href="{{ route('prestamos.index', ['usuario' => $usuario->id]) }}" class="btn btn-outline">
                    Ver Historial Completo
                </a>
            </div>
        @endif
    </div>
</div>
@endif
@endsection