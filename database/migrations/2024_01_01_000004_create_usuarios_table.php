<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_estudiante', 20)->unique()->nullable();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 150)->unique();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->enum('tipo_usuario', ['estudiante', 'profesor', 'bibliotecario', 'admin'])->default('estudiante');
            $table->enum('estado', ['activo', 'suspendido', 'inactivo'])->default('activo');
            $table->date('fecha_registro')->default(now());
            $table->decimal('multa_pendiente', 10, 2)->default(0.00);
            $table->timestamps();
            
            $table->index(['codigo_estudiante']);
            $table->index(['tipo_usuario']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
