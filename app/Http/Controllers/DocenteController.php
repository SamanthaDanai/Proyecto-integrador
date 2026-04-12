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
            'genero'      => 'required|in:Masculino,Femenino',
            'perfil'      => 'nullable|string|max:200',
            'fotografia'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->except('fotografia');

        if ($request->hasFile('fotografia')) {
            $path = $request->file('fotografia')->store('docentes', 'public');
            $data['fotografia'] = $path;
        }

        Docente::create($data);

        return redirect()->route('docentes.index')->with('ok', 'Docente agregado correctamente.');
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
            'genero'      => 'required|in:Masculino,Femenino',
            'perfil'      => 'nullable|string|max:200',
            'fotografia'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->except(['fotografia', 'no_empleado']);

        if ($request->hasFile('fotografia')) {
            // Eliminar foto antigua si existe
            if ($docente->fotografia && Storage::disk('public')->exists($docente->fotografia)) {
                Storage::disk('public')->delete($docente->fotografia);
            }
            $path = $request->file('fotografia')->store('docentes', 'public');
            $data['fotografia'] = $path;
        }

        $docente->update($data);

        return redirect()->route('docentes.index')->with('ok', 'Docente actualizado correctamente.');
    }

    // Eliminar
    public function destroy(Docente $docente)
    {
        if ($docente->fotografia && Storage::disk('public')->exists($docente->fotografia)) {
            Storage::disk('public')->delete($docente->fotografia);
        }
        $docente->delete();
        return redirect()->route('docentes.index')->with('ok', 'Docente eliminado correctamente.');
    }
}
