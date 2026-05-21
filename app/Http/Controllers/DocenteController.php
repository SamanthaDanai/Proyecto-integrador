<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class DocenteController extends Controller
{
    // Mostrar lista
    public function index()
    {
        $data = Docente::all();
        return view('cpanel.docentes.indexdocentes', compact('data'));
    }

    // Formulario de creación
    public function create()
    {
        return view('cpanel.docentes.createdocentes');
    }

    // Guardar nuevo docente
    public function store(Request $request)
    {
        $request->validate([
            'no_empleado' => 'required|string|max:20|unique:docente,no_empleado',
            'nombre'      => 'required|string|max:50',
            'apet'        => 'required|string|max:50',
            'amat'        => 'required|string|max:50',
            'correo'      => 'required|email|max:100|unique:usuario,correo_inst',
            'contrasena'  => 'required|string|min:6',
            'genero'      => 'required|in:Masculino,Femenino',
            'perfil'      => 'nullable|string|max:200',
            'telefono'    => 'nullable|string|max:20',
            'area'        => 'nullable|string|max:100',
            'fotografia'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->except(['fotografia', 'contrasena']);

        if ($request->hasFile('fotografia')) {
            $path = $request->file('fotografia')->store('docentes', 'public');
            $data['fotografia'] = $path;
        }

        Docente::create($data);

        // Crear automáticamente el usuario (cuenta de acceso) para este docente usando el correo ingresado
        \App\Models\Usuario::create([
            'num_control' => $request->no_empleado,
            'nombre' => $request->nombre,
            'apat' => $request->apet,
            'amat' => $request->amat,
            'genero' => $request->genero,
            'correo_inst' => $request->correo,
            'contrasena' => bcrypt($request->contrasena), // Contraseña ingresada
            'id_tipo' => 4, // 4 = Docente
            // Los campos de estudiante no aplican, pero si la BD los exige, los llenamos con valores por defecto válidos
            'carrera' => 'N/A',
            'generacion' => 'N/A',
            'turno' => 'Matutino' // Debe ser válido según ENUM ('Matutino', 'Vespertino')
        ]);

        return redirect()->route('docentes.index')->with('ok', "Docente agregado. Su correo de acceso es: {$request->correo}");
    }

    // Formulario de edición
    public function edit(Docente $docente)
    {
        return view('cpanel.docentes.editdocentes', compact('docente'));
    }

    // Actualizar docente
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nombre'      => 'required|string|max:50',
            'apet'        => 'required|string|max:50',
            'amat'        => 'required|string|max:50',
            'correo'      => 'required|email|max:100',
            'contrasena'  => 'nullable|string|min:6',
            'genero'      => 'required|in:Masculino,Femenino',
            'perfil'      => 'nullable|string|max:200',
            'telefono'    => 'nullable|string|max:20',
            'area'        => 'nullable|string|max:100',
            'fotografia'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->except(['fotografia', 'no_empleado', 'contrasena']);

        if ($request->hasFile('fotografia')) {
            // Eliminar foto antigua si existe
            if ($docente->fotografia && Storage::disk('public')->exists($docente->fotografia)) {
                Storage::disk('public')->delete($docente->fotografia);
            }
            $path = $request->file('fotografia')->store('docentes', 'public');
            $data['fotografia'] = $path;
        }

        $docente->update($data);

        // Sincronizar con la tabla usuario (crear si no existe, actualizar si sí)
        $usuarioData = [
            'correo_inst' => $request->correo,
            'nombre' => $request->nombre,
            'apat' => $request->apet,
            'amat' => $request->amat,
            'genero' => $request->genero,
            'id_tipo' => 4, // Asegurar que sea Docente
            'turno' => 'Matutino',
            'carrera' => 'N/A',
            'generacion' => 'N/A'
        ];

        // Si escribió una nueva contraseña, la actualizamos
        if ($request->filled('contrasena')) {
            $usuarioData['contrasena'] = bcrypt($request->contrasena);
        }

        \App\Models\Usuario::updateOrCreate(
            ['num_control' => $docente->no_empleado],
            $usuarioData
        );

        return redirect()->route('docentes.index')->with('ok', 'Docente actualizado correctamente.');
    }

    public function destroy(Docente $docente)
    {
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $foto = $docente->fotografia;
            $no_empleado = $docente->no_empleado;

            // Intentamos borrar el docente primero para que, si hay constraint (ej. en act_extraesc),
            // salte la excepción antes de borrar al usuario o la foto.
            $docente->delete();

            // Eliminar también la cuenta de usuario asociada
            \App\Models\Usuario::where('num_control', $no_empleado)->delete();

            \Illuminate\Support\Facades\DB::commit();

            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            return redirect()->route('docentes.index')->with('ok', 'Docente y su cuenta de acceso eliminados correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            if ($e->getCode() == "23000") {
                return redirect()->route('docentes.index')->with('error', 'No se puede eliminar el docente porque está asignado a actividades extraescolares u otros registros.');
            }
            return redirect()->route('docentes.index')->with('error', 'Ocurrió un error al intentar eliminar el docente.');
        }
    }

    // Activar/Desactivar docente
    public function toggle(Docente $docente)
    {
        $docente->activo = !$docente->activo;
        $docente->save();

        $estadoStr = $docente->activo ? 'activado' : 'inactivado';
        return redirect()->route('docentes.index')->with('ok', "El docente {$docente->nombre} ha sido {$estadoStr} correctamente.");
    }
}
