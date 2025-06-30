<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Usuario;
use Carbon\Carbon;

class ActualizarPrestamosVencidos extends Command
{
    protected $signature = 'prestamos:actualizar-vencidos';
    protected $description = 'Actualiza el estado de préstamos vencidos y calcula multas';

    public function handle()
    {
        $this->info('Iniciando actualización de préstamos vencidos...');
        
        $prestamosVencidos = Prestamo::where('estado', 'activo')
            ->where('fecha_devolucion_esperada', '<', now())
            ->with('usuario')
            ->get();
        
        $totalActualizados = 0;
        $totalMultas = 0;
        
        foreach ($prestamosVencidos as $prestamo) {
            $diasVencido = now()->diffInDays($prestamo->fecha_devolucion_esperada);
            $multa = $diasVencido * 0.50; // 50 centavos por día
            
            // Actualizar préstamo
            $prestamo->update([
                'estado' => 'vencido',
                'multa' => $multa
            ]);
            
            // Actualizar multa del usuario
            $prestamo->usuario->increment('multa_pendiente', $multa);
            
            $totalActualizados++;
            $totalMultas += $multa;
            
            $this->line("Préstamo #{$prestamo->id} - Usuario: {$prestamo->usuario->nombre_completo} - Multa: $" . number_format($multa, 2));
        }
        
        $this->info("\nResumen:");
        $this->info("Préstamos actualizados: {$totalActualizados}");
        $this->info("Total en multas: $" . number_format($totalMultas, 2));
        
        return 0;
    }
}
