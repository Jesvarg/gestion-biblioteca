@extends('layouts.app')

@section('title', 'Préstamos Vencidos')

@section('content')
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="page-title">Préstamos Vencidos</h1>
            <p class="page-subtitle">Lista de préstamos que han superado su fecha de devolución</p>
        </div>
        <a href="{{ route('reportes.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Volver a Reportes
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($prestamosVencidos->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Libro</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Esperada</th>
                            <th>Días Vencido</th>
                            <th>Multa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamosVencidos as $prestamo)
                            <tr>
                                <td>
                                    <div>
                                        <div style="font-weight: 600;">{{ $prestamo->usuario->nombre_completo }}</div>
                                        <div class="text-sm" style="color: var(--secondary);">{{ $prestamo->usuario->email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 600;">{{ $prestamo->libro->titulo }}</div>
                                        <div class="text-sm" style="color: var(--secondary);">{{ $prestamo->libro->autor->nombre_completo ?? 'Sin autor' }}</div>
                                    </div>
                                </td>
                                <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                <td>{{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-danger">
                                        {{ $prestamo->fecha_devolucion_esperada->diffInDays(now()) }} días
                                    </span>
                                </td>
                                <td>
                                    @if(method_exists($prestamo, 'calcularMulta'))
                                        ${{ number_format($prestamo->calcularMulta(), 2) }}
                                    @else
                                        ${{ number_format($prestamo->fecha_devolucion_esperada->diffInDays(now()) * 0.50, 2) }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center" style="padding: 3rem;">
                <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--success); opacity: 0.5; margin-bottom: 1rem;"></i>
                <h3 style="color: var(--secondary); margin-bottom: 1rem;">¡Excelente!</h3>
                <p style="color: var(--secondary);">No hay préstamos vencidos en este momento.</p>
            </div>
        @endif
    </div>
</div>
@endsection