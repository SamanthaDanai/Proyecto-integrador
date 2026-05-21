<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Completando migración de registros restantes ===\n\n";

// Usar raw SQL para valores numéricos que Laravel interpreta mal
$queries = [
    ["UPDATE usuario SET generacion = 'Agosto-diciembre 2024' WHERE generacion = '2024'", "'2024' → 'Agosto-diciembre 2024'"],
    ["UPDATE usuario SET generacion = 'Enero-junio 2026' WHERE generacion = '2026'", "'2026' → 'Enero-junio 2026'"],
    ["UPDATE usuario SET generacion = 'Enero-junio 2025' WHERE generacion = 'N/A'", "'N/A' → 'Enero-junio 2025'"],
    ["UPDATE usuario SET generacion = 'Enero-junio 2025' WHERE generacion IS NULL OR generacion = ''", "'(null/vacío)' → 'Enero-junio 2025'"],
];

foreach ($queries as [$sql, $desc]) {
    $affected = DB::affectingStatement($sql);
    if ($affected > 0) {
        echo "  ✓ $desc  ($affected registros)\n";
    } else {
        echo "  — $desc  (ningún registro pendiente)\n";
    }
}

// Verificación final
echo "\n=== DISTRIBUCIÓN FINAL ===\n\n";
$resultado = DB::table('usuario')
    ->select('generacion', DB::raw('COUNT(*) as total'))
    ->groupBy('generacion')
    ->orderByDesc('total')
    ->get();

foreach ($resultado as $r) {
    $gen = $r->generacion ?? '(null)';
    echo sprintf("  %-35s => %d estudiantes\n", $gen, $r->total);
}

echo "\n  Total registros: " . DB::table('usuario')->count() . "\n";
echo "\n✅ ¡Migración completada exitosamente!\n";
