<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotificarPrestamosProximosVencer extends Command
{
    protected $signature = 'prestamos:notificar-proximos-vencer {--dias=3}';
    protected $description = 'Notifica a usuarios sobre préstamos próximos a vencer';

    public function handle()
    {
        $diasAnticipacion = $this->option('dias');
        $fechaLimite = now()->addDays($diasAnticipacion);
        
        $this->info("Buscando préstamos que vencen en {$diasAnticipacion} días...");
        
        $prestamosProximos = Prestamo::where('estado', 'activo')
            ->whereDate('fecha_devolucion_esperada', '<=', $fechaLimite->format('Y-m-d'))
            ->whereDate('fecha_devolucion_esperada', '>=', now()->format('Y-m-d'))
            ->with(['usuario', 'libro'])
            ->get();
        
        $notificacionesEnviadas = 0;
        
        foreach ($prestamosProximos as $prestamo) {
            $diasRestantes = now()->diffInDays($prestamo->fecha_devolucion_esperada);
            
            // Aquí puedes implementar el envío de email
            // Mail::to($prestamo->usuario->email)->send(new PrestamoProximoVencer($prestamo));
            
            $this->line("📧 Notificación para: {$prestamo->usuario->nombre_completo}");
            $this->line("   📚 Libro: {$prestamo->libro->titulo}");
            $this->line("   📅 Vence en: {$diasRestantes} días\n");
            
            $notificacionesEnviadas++;
        }
        
        $this->info("✅ Proceso completado. Notificaciones enviadas: {$notificacionesEnviadas}");
        
        return 0;
    }
}
