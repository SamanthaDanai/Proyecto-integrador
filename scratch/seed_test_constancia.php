<?php

use App\Models\Usuario;
use App\Models\HistorialExtraescolar;
use App\Models\ActExtraescolar;
use Illuminate\Support\Facades\Hash;

// 1. Crear o actualizar un alumno de prueba
$alumno = Usuario::updateOrCreate(
    ['num_control' => 'TEST2024'],
    [
        'nombre' => 'JUAN PÉREZ',
        'apat' => 'GARCÍA',
        'amat' => 'PRUEBA',
        'correo_inst' => 'j20240001@smartin.tecnm.mx',
        'carrera' => 'Sistemas',
        'generacion' => '2024',
        'id_tipo' => 2, // Estudiante
        'contrasena' => Hash::make('password123')
    ]
);

// 2. Asegurarnos de que existan al menos 2 actividades para asignarle
$act1 = ActExtraescolar::first() ?? ActExtraescolar::create(['nombre' => 'Fútbol', 'activo' => 1, 'horario' => 'Sábado 07:00 - 09:00']);
$act2 = ActExtraescolar::skip(1)->first() ?? ActExtraescolar::create(['nombre' => 'Danza', 'activo' => 1, 'horario' => 'Sábado 09:00 - 11:00']);

// 3. Limpiar historial previo del test y crear 2 periodos aprobados
HistorialExtraescolar::where('num_control', 'TEST2024')->delete();

HistorialExtraescolar::create([
    'num_control' => 'TEST2024',
    'id_act' => $act1->id_act,
    'numero_periodo' => 1,
    'calificacion_final' => 95.0,
    'estado' => 'Aprobado'
]);

HistorialExtraescolar::create([
    'num_control' => 'TEST2024',
    'id_act' => $act2->id_act,
    'numero_periodo' => 2,
    'calificacion_final' => 88.5,
    'estado' => 'Aprobado'
]);

echo "Datos de prueba creados: Alumno TEST2024 listo para expedición de constancia.";
