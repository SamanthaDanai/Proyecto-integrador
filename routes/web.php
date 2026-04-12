<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TipoUsuariosController;
use App\Http\Controllers\ActExtraescolarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\DocenteController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;

// RUTA POR DEFECTO: Si entra en /, que vaya al panel directamente (o a login si no está logeado gracias al middleware)
Route::redirect('/', '/admon');

// --- RUTAS DE AUTENTICACIÓN (LOGIN) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTAS DEL PANEL PROTEGIDAS POR AUTH ---
Route::prefix('admon')->middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/resumen', [DashboardController::class, 'resumen'])->name('resumen');

    // MI PERFIL
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/perfil/actualizar-foto', [PerfilController::class, 'actualizarFoto'])->name('perfil.foto');
    Route::post('/perfil/actualizar-datos', [PerfilController::class, 'actualizarDatos'])->name('perfil.datos');

    // CRUD COMPLETO DE USUARIOS
    Route::get('/reportes/usuarios-data', [UsuariosController::class, 'reportData'])->name('reportes.usuarios-data');
    Route::resource('usuarios', UsuariosController::class);

    Route::resource('tipousuarios', TipoUsuariosController::class);


    Route::get('/tipousuarios', [TipoUsuariosController::class, 'index'])
        ->name('tipousuarios.index');

    Route::resource('actextraescolar', ActExtraescolarController::class);

    // CRUD DE CARRERAS
    Route::resource('carreras', CarreraController::class);

    // CRUD DE DOCENTES
    Route::resource('docentes', DocenteController::class);

    // Toggle status
    Route::post('/tipousuarios/{id}/toggle', [TipoUsuariosController::class, 'toggle'])
        ->name('tipousuarios.toggle');
    Route::post('/actextraescolar/{actextraescolar}/toggle', [ActExtraescolarController::class, 'toggle'])
        ->name('actextraescolar.toggle');
    Route::post('/carreras/{carrera}/toggle', [CarreraController::class, 'toggle'])
        ->name('carreras.toggle');


});


