<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'codigo_estudiante',
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'direccion',
        'tipo_usuario',
        'estado',
        'fecha_registro',
        'multa_pendiente'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'multa_pendiente' => 'decimal:2',
        'password' => 'hashed',
    ];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function prestamosActivos()
    {
        return $this->hasMany(Prestamo::class)->where('estado', 'activo');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function puedePrestar()
    {
        return $this->estado === 'activo' && 
               $this->prestamosActivos()->count() < 3 && 
               $this->multa_pendiente == 0;
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
    
    public function esAdministrador()
    {
        return in_array($this->tipo_usuario, ['bibliotecario', 'admin']);
    }
}