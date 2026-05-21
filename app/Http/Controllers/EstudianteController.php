<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\ActExtraescolar;

use App\Models\HistorialExtraescolar;

class EstudianteController extends Controller
{
    public function index()
    {
        $user = Usuario::with(['actividad.docente', 'actividades.area'])->find(Auth::id());
        
        $historial = HistorialExtraescolar::with('actividadExtraescolar')
            ->where('num_control', $user->num_control)
            ->orderBy('id_historial', 'desc')
            ->get();
            
        $aprobadas = $historial->where('estado', 'Aprobado')->count();

        $actividades = ActExtraescolar::with('docente')
            ->withCount([
                'usuarios as inscritos_hombres' => function ($query) {
                    $query->where('genero', 'Masculino');
                },
                'usuarios as inscritas_mujeres' => function ($query) {
                    $query->where('genero', 'Femenino');
                }
            ])
            ->where('activo', 1)
            ->where('inscripcion_abierta', 1)
            ->get();

        $eventos = $user->actividades;

        return view('estudiante.index', compact('user', 'actividades', 'historial', 'aprobadas', 'eventos'));
    }

    public function inscribir(Request $request)
    {
        $request->validate([
            'carrera' => 'required|string',
            'id_actividad' => 'required|exists:act_extraesc,id_act',
        ]);

        $user = Usuario::find(Auth::id());
        $actividad = ActExtraescolar::find($request->id_actividad);

        // Verificar que la inscripción esté abierta
        if (!$actividad->inscripcion_abierta) {
            return redirect()->back()->withErrors(['id_actividad' => 'La inscripción para esta actividad está cerrada por el administrador.']);
        }

        // Validar cupo por género
        $inscritos = Usuario::where('actividad_extraescolar', $actividad->id_act)
                            ->where('genero', $user->genero)
                            ->count();

        if ($user->genero == 'Masculino' && $inscritos >= $actividad->cupo_masculino) {
            return redirect()->back()->withErrors(['id_actividad' => 'El cupo para HOMBRES en esta actividad está lleno.']);
        }

        if ($user->genero == 'Femenino' && $inscritos >= $actividad->cupo_femenino) {
            return redirect()->back()->withErrors(['id_actividad' => 'El cupo para MUJERES en esta actividad está lleno.']);
        }
        
        // Determinar número de periodo
        $aprobadas = HistorialExtraescolar::where('num_control', $user->num_control)
            ->where('estado', 'Aprobado')
            ->count();
        
        $numero_periodo = $aprobadas + 1;

        // Registrar en historial_extraescolar si no está cursando actualmente
        $cursando = HistorialExtraescolar::where('num_control', $user->num_control)
            ->where('estado', 'Cursando')
            ->first();

        if (!$cursando) {
            HistorialExtraescolar::create([
                'num_control' => $user->num_control,
                'id_act' => $actividad->id_act,
                'tipo' => 'Extraescolar',
                'periodo' => '2026-1',
                'numero_periodo' => $numero_periodo,
                'estado' => 'Cursando'
            ]);
        } else {
            $cursando->update([
                'id_act' => $actividad->id_act
            ]);
        }

        $user->update([
            'carrera' => $request->carrera,
            'actividad_extraescolar' => $request->id_actividad
        ]);

        return redirect()->back()->with('success', '¡Te has inscrito correctamente en tu carrera y actividad extraescolar!');
    }

    public function firmarConformidad($id)
    {
        $historial = HistorialExtraescolar::where('id_historial', $id)
            ->where('num_control', Auth::user()->num_control)
            ->firstOrFail();

        $historial->firma_estudiante = true;
        $historial->save();

        return redirect()->back()->with('success', 'Has firmado de conformidad exitosamente tu calificación.');
    }
}
