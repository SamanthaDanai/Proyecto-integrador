<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Mapeo propuesto: valor antiguo => nuevo valor
$mapeo = [
    '2020-2024' => 'Agosto-diciembre 2024',
    '2021-2025' => 'Enero-junio 2025',
    '2022-2026' => 'Enero-junio 2026',
    '2024'      => 'Agosto-diciembre 2024',
    '2026'      => 'Enero-junio 2026',
    'N/A'       => 'Enero-junio 2025',
    ''          => 'Enero-junio 2025',
    null        => 'Enero-junio 2025',
];

echo "=== PREVISUALIZACIÓN DE MIGRACIÓN ===\n\n";
echo sprintf("%-30s => %-35s => %s\n", "VALOR ACTUAL", "NUEVO VALOR", "AFECTADOS");
echo str_repeat("-", 80) . "\n";

foreach ($mapeo as $viejo => $nuevo) {
    $viejo_display = ($viejo === '' || $viejo === null) ? '(vacío/null)' : $viejo;
    $total = DB::table('usuario')
        ->when($viejo === null || $viejo === '', function($q) {
            $q->whereNull('generacion')->orWhere('generacion', '');
        }, function($q) use ($viejo) {
            $q->where('generacion', $viejo);
        })
        ->count();
    
    if ($total > 0) {
        echo sprintf("%-30s => %-35s => %d estudiantes\n", $viejo_display, $nuevo, $total);
    }
}

echo str_repeat("-", 80) . "\n";
echo "Total registros en la tabla: " . DB::table('usuario')->count() . "\n";
echo "\n⚠️  Este script NO modifica nada. Solo es una previsualización.\n";
