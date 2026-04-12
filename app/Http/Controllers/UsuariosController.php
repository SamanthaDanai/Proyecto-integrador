<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UsuariosController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $data = Usuario::with(['tipo', 'actividad'])->get();
        return view('cpanel.usuarios.indexusuarios', compact('data'));
    }

    // Mostrar formulario de crear usuario
    public function create()
    {
        return view('cpanel.usuarios.createusuarios');
    }

    // Guardar usuario en la BD
    public function store(Request $request)
    {
        Usuario::create([
            'num_control' => $request->num_control,
            'nombre' => $request->nombre,
            'apat' => $request->apat,
            'amat' => $request->amat,
            'genero' => $request->genero,
            'turno' => $request->turno,
            'correo_inst' => $request->correo_inst,
            'carrera' => $request->carrera,
            'generacion' => $request->generacion,
            'actividad_extraescolar' => $request->actividad_extraescolar,
            'id_tipo' => $request->id_tipo,
            'contrasena' => bcrypt($request->contrasena)
        ]);

        return redirect()->route('usuarios.index')->with('ok','Usuario agregado correctamente');
    }

    // Mostrar formulario de editar usuario
    public function edit($num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        return view('cpanel.usuarios.editusuarios', compact('usuario'));
    }

    // Actualizar usuario en la BD
    public function update(Request $request, $num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        
        $datos = [
            'num_control' => $request->num_control,
            'nombre' => $request->nombre,
            'apat' => $request->apat,
            'amat' => $request->amat,
            'genero' => $request->genero,
            'turno' => $request->turno,
            'correo_inst' => $request->correo_inst,
            'carrera' => $request->carrera,
            'generacion' => $request->generacion,
            'actividad_extraescolar' => $request->actividad_extraescolar,
            'id_tipo' => $request->id_tipo,
        ];

        // Solo actualizar contraseña si se proporciona una nueva
        if ($request->filled('contrasena')) {
            $datos['contrasena'] = bcrypt($request->contrasena);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy($num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('ok', 'Usuario eliminado correctamente');
    }

    // Retornar datos para reportes (JSON)
    public function reportData()
    {
        $usuarios = Usuario::with(['tipo', 'actividad'])->get();
        return response()->json($usuarios);
    }
}
