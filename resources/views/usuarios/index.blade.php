@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Gestión de Usuarios</h1>
            <p class="page-subtitle">Administra los usuarios del sistema</p>
        </div>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nuevo Usuario
        </a>
    </div>
</div>

<!-- Filtros de búsqueda -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('usuarios.index') }}" class="grid grid-3 gap-4">
            <div class="form-group">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre, email o código..." value="{{ request('buscar') }}">
            </div>
            
            <div class="form-group">
                <select name="tipo" class="form-control">
                    <option value="">Todos los tipos</option>
                    <option value="estudiante" {{ request('tipo') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                    <option value="profesor" {{ request('tipo') == 'profesor' ? 'selected' : '' }}>Profesor</option>
                    <option value="bibliotecario" {{ request('tipo') == 'bibliotecario' ? 'selected' : '' }}>Bibliotecario</option>
                    <option value="admin" {{ request('tipo') == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline ml-2">
                    <i class="fas fa-times"></i>
                    Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Lista de usuarios -->
<div class="card">
    <div class="card-body">
        @if(isset($usuarios) && $usuarios->count() > 0)
            <div class="table-responsive">
                <table class="table table-improved">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Nombre</th>
                            <th style="width: 20%;">Email</th>
                            <th style="width: 12%;">Tipo</th>
                            <th style="width: 12%;">Código</th>
                            <th style="width: 12%;">Préstamos</th>
                            <th style="width: 19%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name">{{ $usuario->nombre }} {{ $usuario->apellido }}</div>
                                        <div class="user-meta">Registrado: {{ $usuario->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="email-cell">{{ $usuario->email }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $usuario->tipo_usuario === 'admin' ? 'danger' : ($usuario->tipo_usuario === 'bibliotecario' ? 'warning' : 'primary') }}">
                                        {{ ucfirst($usuario->tipo_usuario) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="codigo-cell">{{ $usuario->codigo_estudiante ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $usuario->prestamos_activos_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-outline" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($usuario->tipo_usuario !== 'admin')
                                            @if($usuario->estado === 'activo')
                                                <form method="POST" action="{{ route('usuarios.bloquear', $usuario) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Bloquear usuario?')" title="Bloquear">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('usuarios.activar', $usuario) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" title="Activar">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-secondary" title="Editar">
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
            
            @if(method_exists($usuarios, 'links'))
                <div class="mt-4">
                    {{ $usuarios->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="text-center" style="padding: 3rem;">
                <i class="fas fa-users" style="font-size: 4rem; color: var(--secondary); opacity: 0.5; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--secondary); margin-bottom: 1rem;">No se encontraron usuarios</h3>
                <p style="color: var(--secondary); margin-bottom: 2rem;">No hay usuarios que coincidan con los criterios de búsqueda.</p>
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Crear Primer Usuario
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-improved {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table-improved th {
        background: #f8fafc;
        font-weight: 600;
        padding: 1rem;
        border-bottom: 2px solid #e5e7eb;
        text-align: left;
    }
    
    .table-improved td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: top;
    }
    
    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .user-name {
        font-weight: 600;
        color: var(--dark);
    }
    
    .user-meta {
        font-size: 0.875rem;
        color: var(--secondary);
    }
    
    .email-cell {
        word-break: break-word;
        max-width: 200px;
    }
    
    .codigo-cell {
        font-family: monospace;
        font-size: 0.875rem;
    }
    
    .actions-cell {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .actions-cell .btn {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-improved tr:hover {
        background: #f8fafc;
    }
</style>
@endpush