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
            $table->morphs('solicitante'); // Esto crea solicitante_id y solicitante_type
            $table->string('mensaje');
            $table->boolean('leido')->default(false);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');  
    }
};
