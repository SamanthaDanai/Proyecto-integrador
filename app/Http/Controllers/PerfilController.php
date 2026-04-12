<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;

class PerfilController extends Controller
{
    public function index()
    {
        return view('cpanel.perfil.index');
    }

    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'fotografia' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('fotografia')) {
            if ($user->fotografia_perfil) {
                Storage::disk('public')->delete('perfiles/' . $user->fotografia_perfil);
            }

            $file = $request->file('fotografia');
            $filename = 'perfil_' . $user->num_control . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('perfiles', $filename, 'public');

            Usuario::where('num_control', $user->num_control)->update([
                'fotografia_perfil' => $filename
            ]);
        }

        return back()->with('success', 'Fotografía actualizada correctamente.');
    }

    public function actualizarDatos(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $updateData = ['nombre' => $request->nombre];

        if ($request->filled('nueva_contrasena')) {
            // Validamos con el formato especifico solicitado por el cliente.
            $request->validate([
                'nueva_contrasena' => ['regex:/^[a-zA-Z]{8}[0-9]{1}[\W_]{1}$/']
            ], [
                'nueva_contrasena.regex' => 'La contraseña debe tener 8 letras, 1 número y 1 símbolo especial.'
            ]);

            $updateData['contrasena'] = $request->nueva_contrasena;
        }

        Usuario::where('num_control', $user->num_control)->update($updateData);

        return back()->with('success', 'Datos actualizados correctamente.');
    }
}
