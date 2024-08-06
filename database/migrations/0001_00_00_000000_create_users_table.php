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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id')->nullable();;
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Insertar usuarios por defecto
        $roles = DB::table('roles')->get()->keyBy('nombre');

        $doctor = DB::table('doctores')->insertGetId([
            'nombres' => 'Doctor',
            'apellidos' => 'Doctor',
            'correo' => 'doctor@doctor.com',
            'password' => Hash::make('doctorupv'),
            'telefono' => 123456789,
            'especialidad' => 'cardiologia',
            'precio_consulta' => 500,
            'duracion_cita' => 30,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('doctor_roles')->insert([
            'doctor_id' => $doctor,
            'role_id' => $roles['Doctor']->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $secretaria = DB::table('secretarias')->insertGetId([
            'nombres' => 'Secretaria',
            'apellidos' => 'Secretaria',
            'correo' => 'secretaria@secretaria.com',
            'password' => Hash::make('secretariaupv'),
            'telefono' => 987654321,
            'role_id' => $roles['Secretaria']->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Doctor',
                'email' => 'doctor@doctor.com',
                'password' => Hash::make('doctorupv'),
                'role_id' => $roles['Doctor']->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Secretaria',
                'email' => 'secretaria@secretaria.com',
                'password' => Hash::make('secretariaupv'),
                'role_id' => $roles['Secretaria']->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('adminupv'),
                'role_id' => $roles['Admin']->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
