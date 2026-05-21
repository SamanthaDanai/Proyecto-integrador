<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function index()
    {
        // Solo usuarios tipo 1 (Administrador)
        $admins = Usuario::where('id_tipo', 1)->get();
        return view('cpanel.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('cpanel.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'num_control' => 'required|unique:usuario,num_control',
            'correo_inst' => 'required|email|unique:usuario,correo_inst',
            'contrasena' => 'required|min:6'
        ]);

        Usuario::create([
            'num_control'          => $request->num_control,
            'nombre'               => $request->nombre,
            'apat'                 => $request->apat,
            'amat'                 => $request->amat,
            'correo_inst'          => $request->correo_inst,
            'id_tipo'              => 1, // Administrador
            'contrasena'           => Hash::make($request->contrasena),
            // Campos requeridos por la BD pero no aplican a admins
            'genero'               => null,
            'turno'                => null,
            'carrera'              => null,
            'generacion'           => null,
            'actividad_extraescolar' => null,
        ]);

        return redirect()->route('administradores.index')->with('success', 'Administrador creado correctamente.');
    }

    public function edit($num_control)
    {
        $admin = Usuario::where('num_control', $num_control)->firstOrFail();
        return view('cpanel.admins.edit', compact('admin'));
    }

    public function update(Request $request, $num_control)
    {
        $admin = Usuario::where('num_control', $num_control)->firstOrFail();

        $request->validate([
            'num_control' => 'required|unique:usuario,num_control,'.$admin->num_control.',num_control',
            'correo_inst' => 'required|email|unique:usuario,correo_inst,'.$admin->num_control.',num_control',
        ]);

        $data = [
            'num_control' => $request->num_control,
            'nombre' => $request->nombre,
            'apat' => $request->apat,
            'amat' => $request->amat,
            'correo_inst' => $request->correo_inst,
        ];

        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        $admin->update($data);

        return redirect()->route('administradores.index')->with('success', 'Administrador actualizado correctamente.');
    }

    public function destroy($num_control)
    {
        $admin = Usuario::where('num_control', $num_control)->firstOrFail();
        $admin->delete();

        return redirect()->route('administradores.index')->with('success', 'Administrador eliminado correctamente.');
    }
}
