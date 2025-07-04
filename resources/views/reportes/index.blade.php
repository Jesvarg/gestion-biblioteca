@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
<div class="page-header">
    <h1 class="page-title">Reportes</h1>
    <p class="page-subtitle">Consulta estadísticas y reportes del sistema</p>
</div>

<div class="grid grid-2 gap-6">
    <!-- Reportes de Préstamos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exchange-alt text-primary"></i>
                Reportes de Préstamos
            </h3>
        </div>
        <div class="card-body">
            <div class="space-y-3">
                <a href="{{ route('reportes.prestamos-vencidos') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                    Préstamos Vencidos
                </a>
                <a href="{{ route('reportes.prestamos-activos') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-clock text-warning"></i>
                    Préstamos Activos
                </a>
                <a href="{{ route('reportes.historial-prestamos') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-history text-info"></i>
                    Historial de Préstamos
                </a>
            </div>
        </div>
    </div>

    <!-- Reportes de Libros -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-book text-success"></i>
                Reportes de Libros
            </h3>
        </div>
        <div class="card-body">
            <div class="space-y-3">
                <a href="{{ route('reportes.libros-populares') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-star text-warning"></i>
                    Libros Más Populares
                </a>
                <a href="{{ route('reportes.libros-disponibles') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-check-circle text-success"></i>
                    Libros Disponibles
                </a>
                <a href="{{ route('reportes.inventario') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-warehouse text-primary"></i>
                    Inventario General
                </a>
            </div>
        </div>
    </div>

    <!-- Reportes de Usuarios -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users text-info"></i>
                Reportes de Usuarios
            </h3>
        </div>
        <div class="card-body">
            <div class="space-y-3">
                <a href="{{ route('reportes.usuarios-activos') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-user-check text-success"></i>
                    Usuarios Más Activos
                </a>
                <a href="{{ route('reportes.usuarios-morosos') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-user-times text-danger"></i>
                    Usuarios Morosos
                </a>
                <a href="{{ route('reportes.nuevos-usuarios') }}" class="btn btn-outline w-full justify-start">
                    <i class="fas fa-user-plus text-primary"></i>
                    Nuevos Usuarios
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar text-secondary"></i>
                Estadísticas Generales
            </h3>
        </div>
        <div class="card-body">
            <div class="grid grid-2 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ $totalLibros ?? 0 }}</div>
                    <div class="text-sm text-secondary">Total Libros</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-success">{{ $totalUsuarios ?? 0 }}</div>
                    <div class="text-sm text-secondary">Total Usuarios</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-warning">{{ $prestamosActivos ?? 0 }}</div>
                    <div class="text-sm text-secondary">Préstamos Activos</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-danger">{{ $prestamosVencidos ?? 0 }}</div>
                    <div class="text-sm text-secondary">Préstamos Vencidos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">Exportar Reportes</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-3 gap-4">
            <button class="btn btn-success">
                <i class="fas fa-file-excel"></i>
                Exportar a Excel
            </button>
            <button class="btn btn-danger">
                <i class="fas fa-file-pdf"></i>
                Exportar a PDF
            </button>
            <button class="btn btn-info">
                <i class="fas fa-print"></i>
                Imprimir Reporte
            </button>
        </div>
    </div>
</div>
@endsection