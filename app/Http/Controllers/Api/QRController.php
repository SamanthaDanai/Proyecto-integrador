<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class QRController extends Controller
{
    // Generar Token
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required',
            'contrasena' => 'required'
        ]);

        $user = Usuario::where('correo_inst', $request->correo)
                       ->orWhere('num_control', $request->correo)
                       ->first();

        if (!$user || !Hash::check($request->contrasena, $user->contrasena)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // Generamos el token usando Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token generado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Generar QR (Protegido por Sanctum)
    public function generarQR(Request $request)
    {
        // Recuperamos el usuario autenticado por el token
        $user = $request->user();

        // El texto que llevará el código QR
        $textoParaQR = "Estudiante: {$user->nombre} {$user->apat} | Num. Control: {$user->num_control}";
        $textoCodificado = urlencode($textoParaQR);
        
        // Usamos la API de QuickChart para generar la imagen del código QR
        $urlQR = "https://quickchart.io/qr?text={$textoCodificado}&size=300";

        return response()->json([
            'message' => 'Código QR generado correctamente con QuickChart API',
            'estudiante' => $user->nombre . ' ' . $user->apat,
            'qr_url' => $urlQR
        ]);
    }
}
