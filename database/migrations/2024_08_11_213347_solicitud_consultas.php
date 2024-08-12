<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitud_consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id'); // ID del doctor que solicita
            $table->unsignedBigInteger('paciente_id'); // ID del paciente
            $table->unsignedBigInteger('consulta_id'); // ID de la consulta solicitada
            $table->boolean('aprobado')->default(false); // Estado de la solicitud
            $table->timestamps();

            // Relacionar con las tablas correspondientes
            $table->foreign('doctor_id')->references('id')->on('medico_colaboradores')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_consultas');
    }
};
