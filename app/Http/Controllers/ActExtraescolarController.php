<?php

namespace App\Http\Controllers;

use App\Models\ActExtraescolar;
use App\Models\Docente;
use Illuminate\Http\Request;

class ActExtraescolarController extends Controller
{
    public function index()
    {
        $data = ActExtraescolar::with('docente')->get();
        return view('cpanel.actextraescolar.indexactextraescolar', compact('data'));
    }

    public function create()
    {
        $docentes = Docente::all();
        return view('cpanel.actextraescolar.createactextraescolar', compact('docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'horario' => 'nullable|string|max:50',
            'cupo_masculino' => 'nullable|integer|min:0',
            'cupo_femenino' => 'nullable|integer|min:0',
            'no_empleado' => 'nullable|exists:docente,no_empleado',
            'lugar' => 'nullable|string|max:100',
            'materiales' => 'nullable|string',
        ]);

        ActExtraescolar::create([
            'nombre' => $request->nombre,
            'horario' => $request->horario ?? 'Por definir',
            'cupo_masculino' => $request->cupo_masculino ?? 15,
            'cupo_femenino' => $request->cupo_femenino ?? 15,
            'no_empleado' => $request->no_empleado,
            'lugar' => $request->lugar,
            'materiales' => $request->materiales,
        ]);

        return redirect()->route('actextraescolar.index')->with('success', 'Actividad creada correctamente.');
    }

    public function edit(ActExtraescolar $actextraescolar)
    {
        $docentes = Docente::all();
        return view('cpanel.actextraescolar.editactextraescolar', [
            'act' => $actextraescolar,
            'docentes' => $docentes
        ]);
    }

    public function update(Request $request, ActExtraescolar $actextraescolar)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'horario' => 'nullable|string|max:50',
            'cupo_masculino' => 'nullable|integer|min:0',
            'cupo_femenino' => 'nullable|integer|min:0',
            'no_empleado' => 'nullable|exists:docente,no_empleado',
            'lugar' => 'nullable|string|max:100',
            'materiales' => 'nullable|string',
        ]);

        $actextraescolar->update([
            'nombre' => $request->nombre,
            'horario' => $request->horario ?? 'Por definir',
            'cupo_masculino' => $request->cupo_masculino ?? 15,
            'cupo_femenino' => $request->cupo_femenino ?? 15,
            'no_empleado' => $request->no_empleado,
            'lugar' => $request->lugar,
            'materiales' => $request->materiales,
        ]);

        return redirect()->route('actextraescolar.index')->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(ActExtraescolar $actextraescolar)
    {
        try {
            $actextraescolar->delete();
            return redirect()->route('actextraescolar.index')->with('success', 'Actividad eliminada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('actextraescolar.index')->with('error', 'No se puede eliminar la actividad porque hay estudiantes u otros registros asociados a ella.');
            }
            return redirect()->route('actextraescolar.index')->with('error', 'Ocurrió un error al intentar eliminar la actividad.');
        }
    }

    public function toggle(ActExtraescolar $actextraescolar)
    {
        $actextraescolar->activo = !$actextraescolar->activo;
        $actextraescolar->save();

        return redirect()->route('actextraescolar.index')
            ->with('success', 'Estado actualizado correctamente');
    }

    public function calificaciones($id)
    {
        $actividad = ActExtraescolar::findOrFail($id);
        
        $inscritos = \App\Models\HistorialExtraescolar::with(['usuario', 'parciales'])
            ->where('id_act', $id)
            ->where('tipo', 'Extraescolar')
            ->get();

        return view('cpanel.actextraescolar.calificaciones', compact('actividad', 'inscritos'));
    }

    public function validarCalificacion(Request $request)
    {
        $request->validate([
            'id_historial' => 'required|exists:historial_extraescolar,id_historial'
        ]);

        $historial = \App\Models\HistorialExtraescolar::findOrFail($request->id_historial);

        // No permitir validar si no hay calificación final registrada
        if ($historial->calificacion_final === null) {
            return redirect()->back()->withErrors('No se puede validar: el docente aún no ha registrado calificaciones para este estudiante.');
        }

        $historial->validacion_admin = true;
        $historial->save();

        return redirect()->back()->with('success', 'Calificación validada correctamente por Administración.');
    }

    public function toggleInscripcion(ActExtraescolar $actextraescolar)
    {
        $actextraescolar->inscripcion_abierta = !$actextraescolar->inscripcion_abierta;
        $actextraescolar->save();

        $estado = $actextraescolar->inscripcion_abierta ? 'abierta' : 'cerrada';
        return redirect()->back()->with('success', "Inscripción $estado correctamente.");
    }

    public function cerrarParcial(Request $request, ActExtraescolar $actextraescolar)
    {
        $request->validate(['num_parcial' => 'required|integer|in:1,2,3']);

        $campo = 'parcial' . $request->num_parcial . '_cerrado';
        $actextraescolar->$campo = !$actextraescolar->$campo;
        $actextraescolar->save();

        $estado = $actextraescolar->$campo ? 'cerrado' : 'abierto';
        return redirect()->back()->with('success', "Parcial {$request->num_parcial} $estado correctamente.");
    }
}
