<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Docente;
use App\Models\Area;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::with(['docentes', 'area'])->get();
        return view('cpanel.actividades.indexactividades', compact('actividades'));
    }

    public function create()
    {
        $docentes = Docente::all();
        $areas = Area::all();
        return view('cpanel.actividades.createactividades', compact('docentes', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'horario' => 'required|string|max:50',
            'id_area' => 'nullable|exists:area,id_area',
            'no_empleado' => 'nullable|exists:docente,no_empleado',
        ]);

        $actividad = Actividad::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'horario' => $request->horario,
            'id_area' => $request->id_area,
            'cupo' => 0, // Eventos might not have a strict cupo like clases
        ]);

        if ($request->filled('no_empleado')) {
            $actividad->docentes()->attach($request->no_empleado, ['periodo' => '2026-1']);
        }

        return redirect()->route('actividades.index')->with('success', 'Evento creado exitosamente.');
    }

    public function edit(Actividad $actividade) 
    {
        $docentes = Docente::all();
        $areas = Area::all();
        $docenteActual = $actividade->docentes->first();
        
        return view('cpanel.actividades.editactividades', compact('actividade', 'docentes', 'areas', 'docenteActual'));
    }

    public function update(Request $request, Actividad $actividade)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'horario' => 'required|string|max:50',
            'id_area' => 'nullable|exists:area,id_area',
            'no_empleado' => 'nullable|exists:docente,no_empleado',
        ]);

        $actividade->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'horario' => $request->horario,
            'id_area' => $request->id_area,
        ]);

        if ($request->filled('no_empleado')) {
            $actividade->docentes()->sync([$request->no_empleado => ['periodo' => '2026-1']]);
        } else {
            $actividade->docentes()->detach();
        }

        return redirect()->route('actividades.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy(Actividad $actividade)
    {
        $actividade->docentes()->detach();
        $actividade->usuarios()->detach();
        
        $actividade->delete();

        return redirect()->route('actividades.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
