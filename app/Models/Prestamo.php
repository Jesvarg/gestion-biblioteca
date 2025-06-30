<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'estado',
        'multa',
        'observaciones',
        'bibliotecario_prestamo_id',
        'bibliotecario_devolucion_id'
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion_esperada' => 'date',
        'fecha_devolucion_real' => 'date',
        'multa' => 'decimal:2'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function bibliotecarioPrestamo()
    {
        return $this->belongsTo(Usuario::class, 'bibliotecario_prestamo_id');
    }

    public function bibliotecarioDevolucion()
    {
        return $this->belongsTo(Usuario::class, 'bibliotecario_devolucion_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'activo')
                    ->where('fecha_devolucion_esperada', '<', now());
    }

    public function estaVencido()
    {
        return $this->estado === 'activo' && 
               $this->fecha_devolucion_esperada < now();
    }

    public function diasVencido()
    {
        if (!$this->estaVencido()) {
            return 0;
        }
        
        return now()->diffInDays($this->fecha_devolucion_esperada);
    }

    public function calcularMulta()
    {
        $diasVencido = $this->diasVencido();
        return $diasVencido > 0 ? $diasVencido * 0.50 : 0; // 50 centavos por día
    }
}
