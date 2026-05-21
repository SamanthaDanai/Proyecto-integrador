<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== PREVISUALIZACIÓN: Poblar historial_extraescolar ===\n\n";

// Mapeo generacion → numero_periodo
$mapPeriodo = [
    'Enero-junio 2025'    => 1,
    'Enero-junio 2026'    => 1,
    'Enero-junio 2027'    => 1,
    'Agosto-diciembre 2024' => 2,
    'Agosto-diciembre 2025' => 2,
    'Agosto-diciembre 2026' => 2,
];

// Alumnos que NO tienen historial aún y SÍ tienen actividad asignada
$alumnos = DB::table('usuario as u')
    ->leftJoin('historial_extraescolar as h', 'u.num_control', '=', 'h.num_control')
    ->whereNull('h.num_control')          // Sin historial
    ->whereNotNull('u.actividad_extraescolar') // Con actividad asignada
    ->where('u.actividad_extraescolar', '!=', '')
    ->select('u.num_control', 'u.nombre', 'u.apat', 'u.generacion', 'u.actividad_extraescolar')
    ->get();

$sinActividad = DB::table('usuario as u')
    ->leftJoin('historial_extraescolar as h', 'u.num_control', '=', 'h.num_control')
    ->whereNull('h.num_control')
    ->where(function($q) {
        $q->whereNull('u.actividad_extraescolar')->orWhere('u.actividad_extraescolar', '');
    })
    ->count();

echo "Alumnos sin historial y CON actividad: " . $alumnos->count() . "\n";
echo "Alumnos sin historial y SIN actividad:  $sinActividad (no se pueden registrar)\n\n";

$p1 = 0; $p2 = 0;
foreach ($alumnos as $a) {
    $periodo = $mapPeriodo[$a->generacion] ?? 1;
    if ($periodo === 1) $p1++;
    else $p2++;
}

echo "Se insertarían en Periodo 1: $p1 registros\n";
echo "Se insertarían en Periodo 2: $p2 registros\n\n";

echo "Primeros 5 registros de ejemplo:\n";
echo str_repeat("-", 70) . "\n";
echo sprintf("%-12s %-25s %-20s %s\n", "No.Control", "Nombre", "Generacion", "Periodo");
echo str_repeat("-", 70) . "\n";
$i = 0;
foreach ($alumnos as $a) {
    if ($i++ >= 5) break;
    $periodo = $mapPeriodo[$a->generacion] ?? 1;
    echo sprintf("%-12s %-25s %-20s %d\n",
        $a->num_control,
        substr($a->nombre . ' ' . $a->apat, 0, 24),
        $a->generacion,
        $periodo
    );
}
echo "\n⚠️  Este script NO modifica nada. Solo previsualización.\n";
