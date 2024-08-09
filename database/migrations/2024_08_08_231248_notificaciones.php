<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('solicitante_id');
            $table->string('mensaje');
            $table->boolean('leido')->default(false);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('solicitante_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');  
    }
};
