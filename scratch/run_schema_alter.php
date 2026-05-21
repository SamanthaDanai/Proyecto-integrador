<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tableName = 'docente';
$columnName = 'activo';

if (Schema::hasTable($tableName)) {
    if (!Schema::hasColumn($tableName, $columnName)) {
        echo "Agregando la columna '$columnName' a la tabla '$tableName'...\n";
        Schema::table($tableName, function (Blueprint $table) {
            $table->boolean('activo')->default(true)->after('area');
        });
        echo "¡Columna agregada exitosamente!\n";
    } else {
        echo "La columna '$columnName' ya existe en la tabla '$tableName'.\n";
    }
} else {
    echo "Error: La tabla '$tableName' no existe.\n";
}
