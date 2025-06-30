<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('libro_id')->constrained('libros')->onDelete('cascade');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion_esperada');
            $table->date('fecha_devolucion_real')->nullable();
            $table->enum('estado', ['activo', 'devuelto', 'vencido', 'renovado'])->default('activo');
            $table->decimal('multa', 10, 2)->default(0.00);
            $table->text('observaciones')->nullable();
            $table->foreignId('bibliotecario_prestamo_id')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->foreignId('bibliotecario_devolucion_id')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['fecha_prestamo']);
            $table->index(['fecha_devolucion_esperada']);
            $table->index(['estado']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
};
