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
        Schema::table('Act_extraesc', function (Blueprint $table) {
            $table->string('lugar')->nullable()->after('horario');
            $table->text('materiales')->nullable()->after('lugar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Act_extraesc', function (Blueprint $table) {
            $table->dropColumn(['lugar', 'materiales']);
        });
    }
};
