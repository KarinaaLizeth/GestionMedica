<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        // Insertar roles solo si no existen
        $roles = ['Doctor', 'Secretaria', 'Admin'];
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $role],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // Tabla intermediaria para los roles de los doctores
        Schema::create('doctor_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('doctor_id')->references('id')->on('doctores')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            // Evitar duplicados
            $table->unique(['doctor_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_roles');
        Schema::dropIfExists('roles');
    }
};
