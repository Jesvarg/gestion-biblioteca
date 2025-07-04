<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_reserva',
        'fecha_expiracion',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
        'fecha_expiracion' => 'date'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function estaVencida()
    {
        return $this->fecha_expiracion < now() && $this->estado === 'activa';
    }
}