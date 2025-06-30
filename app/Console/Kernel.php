<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Usuario;
use Carbon\Carbon;

class GenerarReporteDiario extends Command
{
    protected $signature = 'reportes:diario';
    protected $description = 'Genera reporte diario de actividades de la biblioteca';

    public function handle()
    {
        $fecha = now()->format('Y-m-d');
        $this->info("Generando reporte diario para: {$fecha}");
        
        // Préstamos del día
        $prestamosHoy = Prestamo::whereDate('created_at', $fecha)->count();
        
        // Devoluciones del día
        $devolucionesHoy = Prestamo::whereDate('fecha_devolucion_real', $fecha)->count();
        
        // Nuevos usuarios
        $usuariosNuevos = Usuario::whereDate('created_at', $fecha)->count();
        
        // Libros más prestados hoy
        $librosPrestadosHoy = Libro::withCount(['prestamos' => function($query) use ($fecha) {
            $query->whereDate('created_at', $fecha);
        }])
        ->having('prestamos_count', '>', 0)
        ->orderBy('prestamos_count', 'desc')
        ->take(5)
        ->get();
        
        // Mostrar reporte
        $this->info("\n=== REPORTE DIARIO DE BIBLIOTECA ===");
        $this->info("Fecha: {$fecha}");
        $this->info("\nActividad del día:");
        $this->info("- Préstamos realizados: {$prestamosHoy}");
        $this->info("- Devoluciones recibidas: {$devolucionesHoy}");
        $this->info("- Nuevos usuarios registrados: {$usuariosNuevos}");
        
        if ($librosPrestadosHoy->count() > 0) {
            $this->info("\nLibros más prestados hoy:");
            foreach ($librosPrestadosHoy as $libro) {
                $this->info("- {$libro->titulo} ({$libro->prestamos_count} préstamos)");
            }
        }
        
        // Estadísticas generales
        $prestamosActivos = Prestamo::activos()->count();
        $prestamosVencidos = Prestamo::vencidos()->count();
        
        $this->info("\nEstado general:");
        $this->info("- Préstamos activos: {$prestamosActivos}");
        $this->info("- Préstamos vencidos: {$prestamosVencidos}");
        
        return 0;
    }
}
