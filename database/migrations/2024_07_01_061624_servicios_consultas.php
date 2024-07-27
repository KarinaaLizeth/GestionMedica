<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servicios_consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->unsignedBigInteger('servicio_id');
            $table->integer('cantidad_servicio')->nullable();
            $table->decimal('precio', 8, 2);
            $table->text('notas_servicio')->nullable();
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas');
            $table->foreign('servicio_id')->references('id')->on('servicios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('serviciosa_consultas');
    }
};
