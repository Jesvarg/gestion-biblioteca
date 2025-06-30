<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('isbn', 20)->unique()->nullable();
            $table->foreignId('autor_id')->nullable()->constrained('autores')->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
            $table->string('editorial', 150)->nullable();
            $table->year('año_publicacion')->nullable();
            $table->integer('numero_paginas')->nullable();
            $table->integer('cantidad_total')->default(1);
            $table->integer('cantidad_disponible')->default(1);
            $table->string('ubicacion', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'mantenimiento'])->default('activo');
            $table->timestamps();
            
            $table->index(['titulo']);
            $table->index(['isbn']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('libros');
    }
};
