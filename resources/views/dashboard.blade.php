@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Resumen general del sistema de biblioteca</p>
</div>

<!-- Acciones rápidas -->
<div class="card mt-4 mb-4">
    <div class="card-header">
        <h3 class="card-title">Acciones Rápidas</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-2 gap-4">
            <a href="{{ route('prestamos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nuevo Préstamo
            </a>
            <a href="{{ route('libros.create') }}" class="btn btn-success">
                <i class="fas fa-book-medical"></i>
                Registrar Libro
            </a>
        </div>
    </div>
</div>

<!-- Estadísticas principales -->
<div class="grid grid-4 mb-4">
    <div class="card">
        <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--primary); margin-bottom: 0.5rem;">
                <i class="fas fa-book"></i>
            </div>
            <h3 style="font-size: 2rem; margin-bottom: 0.25rem;">{{ number_format($totalLibros ?? 0) }}</h3>
            <p class="text-sm" style="color: var(--secondary);">Total de Libros</p>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--success); margin-bottom: 0.5rem;">
                <i class="fas fa-users"></i>
            </div>
            <h3 style="font-size: 2rem; margin-bottom: 0.25rem;">{{ number_format($totalUsuarios ?? 0) }}</h3>
            <p class="text-sm" style="color: var(--secondary);">Usuarios Registrados</p>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--warning); margin-bottom: 0.5rem;">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <h3 style="font-size: 2rem; margin-bottom: 0.25rem;">{{ number_format($prestamosActivos ?? 0) }}</h3>
            <p class="text-sm" style="color: var(--secondary);">Préstamos Activos</p>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--danger); margin-bottom: 0.5rem;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 style="font-size: 2rem; margin-bottom: 0.25rem;">{{ number_format($prestamosVencidos ?? 0) }}</h3>
            <p class="text-sm" style="color: var(--secondary);">Préstamos Vencidos</p>
        </div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Libros más prestados -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Libros Más Prestados</h3>
            <p class="text-sm" style="color: var(--secondary);">Últimos 30 días</p>
        </div>
        <div class="card-body">
            @forelse($librosPrestados ?? [] as $libro)
                <div class="flex items-center justify-between" style="padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 0.25rem;">{{ $libro->titulo }}</h4>
                        <p class="text-sm" style="color: var(--secondary);">{{ $libro->autor->nombre_completo ?? 'Sin autor' }}</p>
                    </div>
                    <div class="text-center">
                        <span style="background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                            {{ $libro->prestamos_count ?? 0 }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center" style="color: var(--secondary); padding: 2rem;">No hay datos disponibles</p>
            @endforelse
        </div>
    </div>
    
    <!-- Usuarios más activos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuarios Más Activos</h3>
            <p class="text-sm" style="color: var(--secondary);">Últimos 30 días</p>
        </div>
        <div class="card-body">
            @forelse($usuariosActivos ?? [] as $usuario)
                <div class="flex items-center justify-between" style="padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 0.25rem;">{{ $usuario->nombre_completo }}</h4>
                        <p class="text-sm" style="color: var(--secondary);">{{ $usuario->codigo_estudiante ?? $usuario->email }}</p>
                        <p class="text-sm" style="color: var(--secondary);">{{ ucfirst($usuario->tipo_usuario) }}</p>
                    </div>
                    <div class="text-center">
                        <span style="background: var(--success); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                            {{ $usuario->prestamos_count ?? 0 }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center" style="color: var(--secondary); padding: 2rem;">No hay datos disponibles</p>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-1 mt-4">
    <!-- Préstamos recientes -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Préstamos Recientes</h3>
        </div>
        <div class="card-body">
            @forelse($prestamosRecientes ?? [] as $prestamo)
                <div class="flex items-center justify-between" style="padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 0.25rem;">{{ $prestamo->libro->titulo }}</h4>
                        <p class="text-sm" style="color: var(--secondary);">{{ $prestamo->usuario->nombre_completo }}</p>
                        <p class="text-sm" style="color: var(--secondary);">{{ $prestamo->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        @if($prestamo->estado === 'activo')
                            @if(method_exists($prestamo, 'estaVencido') && $prestamo->estaVencido())
                                <span style="background: var(--danger); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">Vencido</span>
                            @else
                                <span style="background: var(--success); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">Activo</span>
                            @endif
                        @else
                            <span style="background: var(--secondary); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">{{ ucfirst($prestamo->estado) }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center" style="color: var(--secondary); padding: 2rem;">No hay préstamos recientes</p>
            @endforelse
            
            @if(isset($prestamosRecientes) && $prestamosRecientes->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('prestamos.index') }}" class="btn btn-outline">Ver Todos los Préstamos</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de préstamos
    const ctx = document.getElementById('prestamosChart').getContext('2d');
    const prestamosData = @json($prestamosUltimaSemana);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: prestamosData.map(item => item.fecha),
            datasets: [{
                label: 'Préstamos',
                data: prestamosData.map(item => item.cantidad),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush