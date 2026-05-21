<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Ver todos los valores distintos de generacion existentes y su conteo
$valores = DB::table('usuario')
    ->select('generacion', DB::raw('COUNT(*) as total'))
    ->groupBy('generacion')
    ->orderByDesc('total')
    ->get();

echo "Valores actuales en la columna 'generacion':\n";
echo str_repeat("-", 45) . "\n";
foreach ($valores as $v) {
    $gen = $v->generacion ?? '(vacío/null)';
    echo sprintf("  %-30s => %d estudiantes\n", $gen, $v->total);
}
echo str_repeat("-", 45) . "\n";
echo "Total registros: " . DB::table('usuario')->count() . "\n";
