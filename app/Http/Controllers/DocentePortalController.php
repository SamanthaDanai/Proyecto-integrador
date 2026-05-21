<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\ActExtraescolar;
use App\Models\HistorialExtraescolar;
use App\Models\CalificacionParcial;

class DocentePortalController extends Controller
{
    public function inicio()
    {
        return view('docente.inicio');
    }

    public function index()
    {
        $user = Auth::user();
        $docente = \App\Models\Docente::where('no_empleado', $user->num_control)->first();

        if (!$docente) {
            $docente = \App\Models\Docente::where('nombre', $user->nombre)
                ->where('apet', $user->apat)
                ->first();
        }

        if (!$docente) {
            return redirect()->route('login')->withErrors('No se encontró su perfil de docente asociado.');
        }

        // Obtener actividades asignadas al docente
        $actividades = ActExtraescolar::where('no_empleado', $docente->no_empleado)
            ->where('activo', 1)
            ->get();

        return view('docente.index', compact('user', 'docente', 'actividades'));
    }

    public function eventos()
    {
        $eventos = \App\Models\Actividad::all();
        $areas = \App\Models\Area::all(); // Necesario para crear/editar
        return view('docente.eventos', compact('eventos', 'areas'));
    }

    public function guardarEvento(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'horario' => 'nullable|string',
            'id_area' => 'required|exists:area,id_area'
        ]);

        \App\Models\Actividad::create($request->all());

        return redirect()->back()->with('success', 'Evento institucional creado correctamente.');
    }

    public function actualizarEvento(Request $request, $id)
    {
        $evento = \App\Models\Actividad::findOrFail($id);
        $evento->update($request->all());

        return redirect()->back()->with('success', 'Evento actualizado correctamente.');
    }

    public function eliminarEvento($id)
    {
        $evento = \App\Models\Actividad::findOrFail($id);
        $evento->delete();

        return redirect()->back()->with('success', 'Evento eliminado correctamente.');
    }

    public function horarios()
    {
        $user = Auth::user();
        $docente = \App\Models\Docente::where('no_empleado', $user->num_control)->first();
        $actividades = ActExtraescolar::where('no_empleado', $docente->no_empleado)->get();
        return view('docente.horarios', compact('actividades'));
    }

    public function grupo($id_act)
    {
        $actividad = ActExtraescolar::findOrFail($id_act);
        
        // Obtener historial_extraescolar para esta actividad
        $inscritos = HistorialExtraescolar::with(['usuario', 'parciales'])
            ->where('id_act', $id_act)
            ->where('tipo', 'Extraescolar')
            ->get();

        return view('docente.grupo', compact('actividad', 'inscritos'));
    }

    public function guardarParcial(Request $request, $id_act)
    {
        $request->validate([
            'id_historial' => 'required|exists:historial_extraescolar,id_historial',
            'parciales' => 'required|array',
            'parciales.*.num_parcial' => 'required|integer|min:1|max:3',
            'parciales.*.asistencia' => 'nullable|numeric|min:0|max:100',
            'parciales.*.participacion' => 'nullable|numeric|min:0|max:100',
            'parciales.*.calificacion' => 'nullable|numeric|min:0|max:100',
        ]);

        $historial = HistorialExtraescolar::findOrFail($request->id_historial);
        $actividad = ActExtraescolar::findOrFail($id_act);

        $hayDatos = false;

        foreach ($request->parciales as $p) {
            $numParcial = $p['num_parcial'];
            $campoCerrado = 'parcial' . $numParcial . '_cerrado';

            // Saltar si el parcial está cerrado
            if ($actividad->$campoCerrado) {
                continue;
            }

            // Validar que al menos uno tenga valor
            if (isset($p['asistencia']) && $p['asistencia'] !== '' ||
                isset($p['participacion']) && $p['participacion'] !== '') {

                $asistencia = isset($p['asistencia']) && $p['asistencia'] !== '' ? (float)$p['asistencia'] : 0;
                $participacion = isset($p['participacion']) && $p['participacion'] !== '' ? (float)$p['participacion'] : 0;

                $calificacion = ($asistencia * 0.8) + ($participacion * 0.2);

                CalificacionParcial::updateOrCreate(
                    ['id_historial' => $historial->id_historial, 'num_parcial' => $numParcial],
                    [
                        'asistencia' => $asistencia,
                        'participacion' => $participacion,
                        'calificacion' => $calificacion
                    ]
                );
                $hayDatos = true;
            }
        }

        if (!$hayDatos) {
            return redirect()->back()->withErrors('No se guardó ningún dato. Asegúrate de ingresar al menos asistencia o participación en un parcial abierto.');
        }

        // Recalcular promedio final
        $promedio = CalificacionParcial::where('id_historial', $historial->id_historial)->avg('calificacion');

        $tieneParcial3 = CalificacionParcial::where('id_historial', $historial->id_historial)->where('num_parcial', 3)->exists();

        $estado = 'Cursando';
        if ($tieneParcial3) {
            $estado = $promedio >= 70 ? 'Aprobado' : 'Reprobado';
        }

        $historial->update([
            'calificacion_final' => $promedio,
            'estado' => $estado
        ]);

        return redirect()->back()->with('success', 'Calificaciones guardadas correctamente.');
    }

    public function generarEventosPdf($id)
    {
        $actividad = \App\Models\Actividad::with(['usuarios', 'area'])->findOrFail($id);
        $participantes = $actividad->usuarios;
        
        return view('docente.eventos_pdf', compact('actividad', 'participantes'));
    }

    public function generarEventosExcel($id)
    {
        $actividad = \App\Models\Actividad::with(['usuarios'])->findOrFail($id);
        $participantes = $actividad->usuarios;

        $filename = 'participantes_' . str_replace(' ', '_', strtolower($actividad->nombre)) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($participantes) {
            $file = fopen('php://output', 'w');
            
            // Output UTF-8 BOM for Microsoft Excel compliance
            fwrite($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'No. Control', 
                'Nombre', 
                'Primer Apellido', 
                'Segundo Apellido', 
                'Carrera', 
                'Correo'
            ]);

            // Data rows
            foreach ($participantes as $p) {
                fputcsv($file, [
                    $p->num_control,
                    $p->nombre,
                    $p->apat,
                    $p->amet,
                    $p->carrera ?? 'Sin carrera',
                    $p->correo_inst
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
