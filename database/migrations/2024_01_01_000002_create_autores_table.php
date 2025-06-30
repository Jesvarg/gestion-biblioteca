<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('apellido', 150);
            $table->text('biografia')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nacionalidad', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('autores');
    }
};
