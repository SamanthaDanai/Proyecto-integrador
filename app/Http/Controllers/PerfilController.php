<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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

            $user->update([
                'fotografia_perfil' => $filename
            ]);
        }

        return back()->with('success', 'Fotografía actualizada correctamente.');
    }

    public function actualizarDatos(Request $request)
    {
        $user = Auth::user();

        // Si el usuario es Estudiante (id_tipo == 2), no le permitimos editar datos personales
        if ($user->id_tipo == 2) {
            return back()->withErrors(['error' => 'Como estudiante, solo puedes actualizar tu fotografía de perfil.']);
        }
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'area' => 'nullable|string|max:255',
        ]);

        $updateData = ['nombre' => $request->nombre];

        if ($request->filled('nueva_contrasena')) {
            // Validamos con el formato especifico solicitado por el cliente.
            $request->validate([
                'nueva_contrasena' => ['regex:/^[a-zA-Z]{8}[0-9]{1}[\W_]{1}$/']
            ], [
                'nueva_contrasena.regex' => 'La contraseña debe tener 8 letras, 1 número y 1 símbolo especial.'
            ]);

            $updateData['contrasena'] = Hash::make($request->nueva_contrasena);
        }
        
        $user->update($updateData);

        // Si es Docente (id_tipo == 4), actualizamos también su tabla de docente
        if ($user->id_tipo == 4) {
            $docente = $user->docente;
            if ($docente) {
                $docente->update([
                    'nombre' => $request->nombre, // Sincronizamos nombre
                    'telefono' => $request->telefono,
                    'area' => $request->area
                ]);
            }
        }

        return back()->with('success', 'Datos actualizados correctamente.');
    }
}
