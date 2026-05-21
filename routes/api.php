<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\QRController;

// Ruta pública para obtener el token
Route::post('/login', [QRController::class, 'login']);

// Rutas protegidas por token (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para generar el QR
    Route::get('/generar-qr', [QRController::class, 'generarQR']);

    // Ruta de prueba por defecto
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
