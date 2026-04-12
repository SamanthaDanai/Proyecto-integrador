<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!Schema::hasColumn('usuario', 'fotografia_perfil')) {
    Schema::table('usuario', function (Blueprint $table) {
        $table->string('fotografia_perfil')->nullable();
    });
    echo "Columna fotografía agregada exitosamente.\n";
} else {
    echo "La columna ya existe.\n";
}
