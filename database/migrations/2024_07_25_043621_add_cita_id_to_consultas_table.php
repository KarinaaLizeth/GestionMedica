<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->unsignedBigInteger('cita_id')->nullable()->after('doctor_id');

            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropForeign(['cita_id']);
            $table->dropColumn('cita_id');
        });
    }
};
