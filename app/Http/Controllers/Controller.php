<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller
{
    public function store(Request $request)
    {
        DB::table('Usuario')->insert([
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
            'contrasena' => bcrypt($request->contrasena),
            'id_tipo' => $request->id_tipo
        ]);

        return redirect()->route('usuarios.index');

    }
}
