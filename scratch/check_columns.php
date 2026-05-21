<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tableName = 'docente';
if (Schema::hasTable($tableName)) {
    echo "Columnas en la tabla '$tableName':\n";
    $columns = Schema::getColumnListing($tableName);
    foreach ($columns as $column) {
        $type = Schema::getColumnType($tableName, $column);
        echo " - $column ($type)\n";
    }
} else {
    echo "La tabla '$tableName' no existe.\n";
}
