<?php

namespace App\Http\Controllers;

use App\Models\TipoUsuario;
use Illuminate\Http\Request;

class TipoUsuariosController extends Controller
{
    public function index()
    {
        $data = TipoUsuario::all();
        return view('cpanel.tipousuarios.indextipousuarios', compact('data'));
    }

    public function create()
    {
        return view('cpanel.tipousuarios.createtipousuarios');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        TipoUsuario::create([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('tipousuarios.index')
            ->with('success', 'Tipo de usuario creado correctamente');
    }

    public function edit($id)
    {
        $tipo = TipoUsuario::findOrFail($id);
        return view('cpanel.tipousuarios.edittipousuarios', compact('tipo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $tipo = TipoUsuario::findOrFail($id);
        $tipo->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tipousuarios.index')
            ->with('success', 'Tipo de usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        TipoUsuario::destroy($id);

        return redirect()->route('tipousuarios.index')
            ->with('success', 'Tipo de usuario eliminado correctamente');
    }

    public function toggle($id)
    {
        $tipo = TipoUsuario::findOrFail($id);
        $tipo->activo = !$tipo->activo;
        $tipo->save();

        return redirect()->route('tipousuarios.index')
            ->with('success', 'Estado actualizado correctamente');
    }
}
