<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';
    
    protected $fillable = [
        'nombre',
        'apellido',
        'biografia',
        'fecha_nacimiento',
        'nacionalidad'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date'
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}
