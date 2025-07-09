@if(in_array(auth()->user()->tipo_usuario, ['bibliotecario', 'admin']))
    @extends('layouts.app')
@else
    @extends('layouts.public')
@endif

@section('title', 'Mi Perfil')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Mi Perfil</h1>
            <p class="page-subtitle">Información personal y préstamos</p>
        </div>
    </div>
</div>

<div class="grid grid-2 gap-6">
    <!-- Información Personal -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información Personal</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('perfil.actualizar') }}">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="{{ $usuario->apellido }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ $usuario->telefono }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <textarea name="direccion" class="form-control">{{ $usuario->direccion }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Actualizar Perfil
                </button>
            </form>
        </div>
    </div>
    
    <!-- Préstamos Activos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mis Préstamos Activos</h3>
        </div>
        <div class="card-body">
            @forelse($prestamosActivos as $prestamo)
                <div class="flex items-center justify-between p-3 border rounded mb-2">
                    <div>
                        <div class="font-semibold">{{ $prestamo->libro->titulo }}</div>
                        <div class="text-sm text-gray-600">Vence: {{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</div>
                    </div>
                    <span class="badge {{ $prestamo->estaVencido() ? 'badge-danger' : 'badge-success' }}">
                        {{ $prestamo->estaVencido() ? 'Vencido' : 'Activo' }}
                    </span>
                </div>
            @empty
                <p class="text-center text-gray-500">No tienes préstamos activos</p>
            @endforelse
        </div>
    </div>
</div>
@endsection