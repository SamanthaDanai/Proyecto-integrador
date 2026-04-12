<?php

namespace App\Http\Controllers;

use App\Models\ActExtraescolar;
use Illuminate\Http\Request;

class ActExtraescolarController extends Controller
{
    public function index()
    {
        $data = ActExtraescolar::all();
        return view('cpanel.actextraescolar.indexactextraescolar', compact('data'));
    }

    public function create()
    {
        return view('cpanel.actextraescolar.createactextraescolar');
    }

    public function store(Request $request)
    {
        ActExtraescolar::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('actextraescolar.index');
    }

    public function edit(ActExtraescolar $actextraescolar)
    {
        return view('cpanel.actextraescolar.editactextraescolar', [
            'act' => $actextraescolar
        ]);
    }

    public function update(Request $request, ActExtraescolar $actextraescolar)
    {
        $actextraescolar->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('actextraescolar.index');
    }

    public function destroy(ActExtraescolar $actextraescolar)
    {
        $actextraescolar->delete();

        return redirect()->route('actextraescolar.index');
    }

    public function toggle(ActExtraescolar $actextraescolar)
    {
        $actextraescolar->activo = !$actextraescolar->activo;
        $actextraescolar->save();

        return redirect()->route('actextraescolar.index')
            ->with('success', 'Estado actualizado correctamente');
    }
}
