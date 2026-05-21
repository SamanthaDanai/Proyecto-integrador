<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== AUDITORÍA: TABLA historial_extraescolar ===\n\n";

// Total de registros en historial
$totalHistorial = DB::table('historial_extraescolar')->count();
echo "Total registros en historial_extraescolar: $totalHistorial\n\n";

// Distribución por numero_periodo
$porPeriodo = DB::table('historial_extraescolar')
    ->select('numero_periodo', DB::raw('COUNT(*) as total'))
    ->groupBy('numero_periodo')
    ->orderBy('numero_periodo')
    ->get();

echo "Registros por periodo:\n";
foreach ($porPeriodo as $p) {
    echo "  Periodo {$p->numero_periodo}: {$p->total} registros\n";
}

echo "\n";

// Cuántos usuarios están en historial vs cuántos existen en total
$totalUsuarios = DB::table('usuario')->count();
$usuariosEnHistorial = DB::table('historial_extraescolar')
    ->distinct('num_control')
    ->count('num_control');

echo "Total usuarios en la tabla 'usuario':        $totalUsuarios\n";
echo "Usuarios con registro en historial:          $usuariosEnHistorial\n";
echo "Usuarios SIN ningún historial:               " . ($totalUsuarios - $usuariosEnHistorial) . "\n\n";

// Usuarios en historial del periodo 1
$usuariosPeriodo1 = DB::table('historial_extraescolar')
    ->where('numero_periodo', 1)
    ->distinct('num_control')
    ->count('num_control');
echo "Usuarios únicos en Periodo 1: $usuariosPeriodo1\n";

// Usuarios en historial del periodo 2
$usuariosPeriodo2 = DB::table('historial_extraescolar')
    ->where('numero_periodo', 2)
    ->distinct('num_control')
    ->count('num_control');
echo "Usuarios únicos en Periodo 2: $usuariosPeriodo2\n\n";

// Qué estados existen en historial
$estados = DB::table('historial_extraescolar')
    ->select('estado', DB::raw('COUNT(*) as total'))
    ->groupBy('estado')
    ->get();

echo "Estados registrados en historial_extraescolar:\n";
foreach ($estados as $e) {
    echo "  " . ($e->estado ?? '(null)') . ": {$e->total}\n";
}

// Estructura de la tabla
echo "\nColumnas de historial_extraescolar:\n";
$cols = DB::select("DESCRIBE historial_extraescolar");
foreach ($cols as $col) {
    echo "  - {$col->Field} ({$col->Type})\n";
}
