<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// ── Paso 1: Ampliar la columna generacion ────────────────────────────────────
echo "=== Paso 1: Ampliando columna 'generacion' a VARCHAR(50) ===\n";
DB::statement("ALTER TABLE usuario MODIFY generacion VARCHAR(50) NULL");
echo "  ✓ Columna ampliada correctamente.\n\n";

// ── Paso 2: Migrar valores antiguos ──────────────────────────────────────────
$mapeo = [
    '2020-2024' => 'Agosto-diciembre 2024',
    '2021-2025' => 'Enero-junio 2025',
    '2022-2026' => 'Enero-junio 2026',
    '2024'      => 'Agosto-diciembre 2024',
    '2026'      => 'Enero-junio 2026',
    'N/A'       => 'Enero-junio 2025',
];

echo "=== Paso 2: Migrando valores de generación ===\n\n";
$totalActualizados = 0;

foreach ($mapeo as $viejo => $nuevo) {
    $afectados = DB::table('usuario')->where('generacion', $viejo)->count();
    if ($afectados > 0) {
        DB::table('usuario')->where('generacion', $viejo)->update(['generacion' => $nuevo]);
        echo "  ✓ '$viejo' → '$nuevo'  ($afectados registros)\n";
        $totalActualizados += $afectados;
    }
}

// Nulos y vacíos
$nullVacios = DB::table('usuario')
    ->where(function($q) {
        $q->whereNull('generacion')->orWhere('generacion', '');
    })->count();

if ($nullVacios > 0) {
    DB::table('usuario')
        ->where(function($q) {
            $q->whereNull('generacion')->orWhere('generacion', '');
        })->update(['generacion' => 'Enero-junio 2025']);
    echo "  ✓ '(vacío/null)' → 'Enero-junio 2025'  ($nullVacios registros)\n";
    $totalActualizados += $nullVacios;
}

echo "\nTotal actualizados: $totalActualizados registros\n";

// ── Paso 3: Verificación final ────────────────────────────────────────────────
echo "\n=== Paso 3: Distribución final en la BD ===\n\n";
$resultado = DB::table('usuario')
    ->select('generacion', DB::raw('COUNT(*) as total'))
    ->groupBy('generacion')
    ->orderByDesc('total')
    ->get();

foreach ($resultado as $r) {
    echo sprintf("  %-35s => %d estudiantes\n", $r->generacion, $r->total);
}
echo "\n  Total registros: " . DB::table('usuario')->count() . "\n";
echo "\n✅ ¡Migración completada exitosamente!\n";
