<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'isbn',
        'autor_id',
        'categoria_id',
        'editorial',
        'año_publicacion',
        'numero_paginas',
        'cantidad_total',
        'cantidad_disponible',
        'ubicacion',
        'descripcion',
        'imagen_portada',
        'estado'
    ];

    protected $casts = [
        'año_publicacion' => 'integer',
        'numero_paginas' => 'integer',
        'cantidad_total' => 'integer',
        'cantidad_disponible' => 'integer'
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function scopeDisponibles($query)
    {
        return $query->where('cantidad_disponible', '>', 0)
                    ->where('estado', 'activo');
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('titulo', 'LIKE', "%{$termino}%")
              ->orWhere('isbn', 'LIKE', "%{$termino}%")
              ->orWhereHas('autor', function($autor) use ($termino) {
                  $autor->where('nombre', 'LIKE', "%{$termino}%")
                        ->orWhere('apellido', 'LIKE', "%{$termino}%");
              });
        });
    }

    public function estaDisponible()
    {
        return $this->cantidad_disponible > 0 && $this->estado === 'activo';
    }
}
