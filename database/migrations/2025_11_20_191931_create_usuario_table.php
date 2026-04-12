<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('num_control', 20)->primary();
            $table->string('nombre', 50);
            $table->string('apat', 50);
            $table->string('amat', 50);
            $table->enum('genero', ['Masculino', 'Femenino']);
            $table->enum('turno', ['Matutino','Vespertino']);
            $table->string('correo_inst', 100)->unique();
            $table->string('carrera', 100);
            $table->string('generacion', 15);
            $table->unsignedBigInteger('actividad_extraescolar')->nullable();
            $table->string('contrasena', 200);
            $table->unsignedBigInteger('id_tipo');

            $table->timestamps(); // created_at y updated_at

            // Claves foráneas
            $table->foreign('id_tipo')->references('id_tipo')->on('tipo_usuario')->onDelete('cascade');
            $table->foreign('actividad_extraescolar')->references('id_act')->on('act_extraesc')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
