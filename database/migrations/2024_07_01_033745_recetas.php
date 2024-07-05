<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->string('medicacion');
            $table->integer('cantidad_medicamento');
            $table->string('frecuencia_medicamento');
            $table->string('duracion_medicamento');
            $table->text('notas_receta')->nullable();
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recetas');
    }

};
