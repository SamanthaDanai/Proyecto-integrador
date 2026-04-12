<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CarreraController extends Controller
{
    // Mostrar todas las carreras
    public function index()
    {
        $data = Carrera::all();
        return view('cpanel.carreras.indexcarreras', compact('data'));
    }

    // Formulario de creación
    public function create()
    {
        return view('cpanel.carreras.createcarreras');
    }

    // Guardar nueva carrera
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Carrera::create([
            'nombre_carrera' => $request->nombre,
            'activo' => true,
        ]);

        return redirect()->route('carreras.index')->with('ok', 'Carrera agregada correctamente');
    }

    // Formulario de edición
    public function edit(Carrera $carrera)
    {
        return view('cpanel.carreras.editcarreras', compact('carrera'));
    }

    // Actualizar carrera existente
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $carrera->update([
            'nombre_carrera' => $request->nombre,
        ]);

        return redirect()->route('carreras.index')->with('ok', 'Carrera actualizada correctamente');
    }

    // Eliminar carrera
    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index')->with('ok', 'Carrera eliminada correctamente');
    }

    // Habilitar / Deshabilitar (Toggle)
    public function toggle(Carrera $carrera)
    {
        $carrera->activo = !$carrera->activo;
        $carrera->save();

        $estado = $carrera->activo ? 'habilitada' : 'deshabilitada';
        return redirect()->route('carreras.index')->with('ok', "Carrera $estado correctamente");
    }
}
