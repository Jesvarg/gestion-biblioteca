@extends('layouts.app')

@section('title', 'Gestión de Préstamos')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Gestión de Préstamos</h1>
            <p class="page-subtitle">Administra los préstamos de la biblioteca</p>
        </div>
        <a href="{{ route('prestamos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Préstamo
        </a>
    </div>
</div>

<!-- Filtros de búsqueda -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('prestamos.index') }}" class="grid grid-4 gap-4">
            <div class="form-group">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por libro o usuario..." value="{{ request('buscar') }}">
            </div>
            
            <div class="form-group">
                <select name="estado" class="form-control">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="devuelto" {{ request('estado') == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                    <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
                <a href="{{ route('prestamos.index') }}" class="btn btn-outline ml-2">
                    <i class="fas fa-times"></i>
                    Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Lista de préstamos -->
<div class="card">
    <div class="card-body">
        @if(isset($prestamos) && $prestamos->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Libro</th>
                            <th>Usuario</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamos as $prestamo)
                            <tr>
                                <td>
                                    <div>
                                        <div style="font-weight: 600;">{{ $prestamo->libro->titulo }}</div>
                                        <div class="text-sm" style="color: var(--secondary);">{{ $prestamo->libro->autor->nombre_completo ?? 'Sin autor' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 600;">{{ $prestamo->usuario->nombre_completo }}</div>
                                        <div class="text-sm" style="color: var(--secondary);">{{ $prestamo->usuario->email }}</div>
                                    </div>
                                </td>
                                <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                <td>{{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                                <td>
                                    @if($prestamo->estado === 'activo')
                                        @if(method_exists($prestamo, 'estaVencido') && $prestamo->estaVencido())
                                            <span class="badge badge-danger">Vencido</span>
                                        @else
                                            <span class="badge badge-success">Activo</span>
                                        @endif
                                    @elseif($prestamo->estado === 'devuelto')
                                        <span class="badge badge-secondary">Devuelto</span>
                                    @else
                                        <span class="badge badge-warning">{{ ucfirst($prestamo->estado) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-sm btn-outline">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($prestamo->estado === 'activo')
                                            <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($prestamos, 'links'))
                <div class="mt-4">
                    {{ $prestamos->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center" style="padding: 3rem;">
                <i class="fas fa-exchange-alt" style="font-size: 4rem; color: var(--secondary); opacity: 0.5; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--secondary); margin-bottom: 1rem;">No se encontraron préstamos</h3>
                <p style="color: var(--secondary); margin-bottom: 2rem;">No hay préstamos que coincidan con los criterios de búsqueda.</p>
                <a href="{{ route('prestamos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Crear Primer Préstamo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection