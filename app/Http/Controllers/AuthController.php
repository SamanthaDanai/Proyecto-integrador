<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('cpanel.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

        // Verificación Manual por Contraseñas en Texto Plano
        $user = Usuario::where('correo_inst', $request->correo)
                       ->where('contrasena', $request->contrasena)
                       ->first();

        if ($user) {
            // Iniciar sesión oficial directamente
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        // Si falla
        return back()->withErrors([
            'correo' => 'El correo institucional o la contraseña no coinciden.',
        ])->withInput($request->only('correo'));
    }



    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
