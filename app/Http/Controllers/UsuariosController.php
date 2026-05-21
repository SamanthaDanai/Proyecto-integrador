<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Carrera;
use App\Models\ActExtraescolar;
use App\Models\TipoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class UsuariosController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $data = Usuario::with(['tipo', 'actividad'])->get();
        $carreras = Carrera::all();
        $actividades = ActExtraescolar::all();
        $tipos = TipoUsuario::all();
        
        return view('cpanel.usuarios.indexusuarios', compact('data', 'carreras', 'actividades', 'tipos'));
    }

    // Mostrar formulario de crear usuario
    public function create()
    {
        $carreras = Carrera::all();
        $actividades = ActExtraescolar::all();
        $tipos = TipoUsuario::all();
        
        return view('cpanel.usuarios.createusuarios', compact('carreras', 'actividades', 'tipos'));
    }

    // Guardar usuario en la BD
    public function store(Request $request)
    {
        $request->validate([
            'num_control' => 'required|max:20|unique:usuario,num_control',
            'correo_inst' => ['required', 'regex:/^[A-Za-z][0-9]{8}@smartin\.tecnm\.mx$/', 'unique:usuario,correo_inst'],
        ], [
            'correo_inst.regex' => 'El correo debe tener el formato: una letra, 8 números y @smartin.tecnm.mx (ej. l22240029@smartin.tecnm.mx)',
            'correo_inst.unique' => 'Este correo ya está registrado.',
            'num_control.unique' => 'Este número de control ya está registrado.'
        ]);

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
            'id_tipo' => 2, // Siempre Estudiante
            'contrasena' => Hash::make($request->contrasena)
        ]);

        return redirect()->route('usuarios.index')->with('ok','Usuario agregado correctamente');
    }

    // Mostrar formulario de editar usuario
    public function edit($num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        $carreras = Carrera::all();
        $actividades = ActExtraescolar::all();
        $tipos = TipoUsuario::all();

        return view('cpanel.usuarios.editusuarios', compact('usuario', 'carreras', 'actividades', 'tipos'));
    }

    // Actualizar usuario en la BD
    public function update(Request $request, $num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        
        $request->validate([
            'num_control' => 'required|max:20|unique:usuario,num_control,'.$usuario->num_control.',num_control',
            'correo_inst' => ['required', 'regex:/^[A-Za-z][0-9]{8}@smartin\.tecnm\.mx$/', 'unique:usuario,correo_inst,'.$usuario->num_control.',num_control'],
        ], [
            'correo_inst.regex' => 'El correo debe tener el formato: una letra, 8 números y @smartin.tecnm.mx (ej. l22240029@smartin.tecnm.mx)',
            'correo_inst.unique' => 'Este correo ya está registrado.',
            'num_control.unique' => 'Este número de control ya está registrado.'
        ]);

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
            'id_tipo' => 2, // Siempre Estudiante
        ];

        // Solo actualizar contraseña si se proporciona una nueva
        if ($request->filled('contrasena')) {
            $datos['contrasena'] = Hash::make($request->contrasena);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy($num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        
        // Eliminar registros relacionados para evitar error de llave foránea (1451)
        $usuario->historial_extraescolar()->delete();
        $usuario->actividades()->detach();
        if ($usuario->docente) {
            $usuario->docente()->delete();
        }

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
