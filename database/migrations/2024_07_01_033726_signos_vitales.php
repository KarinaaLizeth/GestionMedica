<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('signos_vitales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->decimal('temperatura', 5, 2);
            $table->integer('talla');
            $table->integer('frecuencia_cardiaca');
            $table->integer('saturacion_oxigeno');
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('signos_vitales');
    }

};
