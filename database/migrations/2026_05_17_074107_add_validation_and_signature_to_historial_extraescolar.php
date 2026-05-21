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
        Schema::table('historial_extraescolar', function (Blueprint $table) {
            $table->boolean('firma_estudiante')->default(false);
            $table->boolean('validacion_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_extraescolar', function (Blueprint $table) {
            $table->dropColumn('firma_estudiante');
            $table->dropColumn('validacion_admin');
        });
    }
};
