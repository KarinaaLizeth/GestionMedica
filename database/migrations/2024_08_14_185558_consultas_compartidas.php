<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultas_compartidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->unsignedBigInteger('medico_colaborador_id');
            $table->unsignedBigInteger('medico_principal_id');
            $table->text('comentarios')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->foreign('medico_colaborador_id')->references('id')->on('medico_colaboradores')->onDelete('cascade');
            $table->foreign('medico_principal_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas_compartidas');
    }
};
