<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\HistorialExtraescolar;
use Illuminate\Support\Facades\Auth;

class ConstanciaController extends Controller
{
    public function index()
    {
        if (Auth::user()->id_tipo != 1) {
            return abort(403, 'Acceso denegado. Solo administradores pueden gestionar constancias.');
        }

        // Encontrar usuarios que tengan 2 historiales con estado 'Aprobado'
        $usuariosLiberados = Usuario::whereHas('historial_extraescolar', function ($query) {
            $query->where('estado', 'Aprobado');
        }, '>=', 2)->with(['historial_extraescolar' => function($q) {
            $q->where('estado', 'Aprobado')->with('actividadExtraescolar');
        }])->get();

        return view('cpanel.constancias.index', compact('usuariosLiberados'));
    }

    public function generarPdf($num_control)
    {
        $user = Auth::user();

        $usuario = Usuario::where('num_control', $num_control)
            ->with(['historial_extraescolar' => function($q) {
                $q->where('estado', 'Aprobado')->with('actividadExtraescolar');
            }])->firstOrFail();

        if ($user->id_tipo != 1) {
            // Estudiante intentando descargar su propia constancia
            if ($user->num_control != $num_control) {
                return abort(403, 'No puedes descargar la constancia de otro alumno.');
            }
            if (!$usuario->permite_descarga_constancia) {
                return redirect()->back()->with('error', 'La descarga de tu constancia ha sido deshabilitada por administración.');
            }

            // Validar límite de impresiones solo para el estudiante
            if ($usuario->impresiones_constancia >= 2) {
                return redirect()->back()->with('error', 'Esta constancia ya ha alcanzado el límite máximo de 2 impresiones.');
            }

            // Incrementar contador solo si es el estudiante quien descarga
            $usuario->increment('impresiones_constancia');
        }

        // Return printable view directly
        return view('cpanel.constancias.pdf', compact('usuario'));
    }

    public function toggleDescarga($num_control)
    {
        if (Auth::user()->id_tipo != 1) {
            return abort(403, 'Acceso denegado.');
        }

        $usuario = Usuario::where('num_control', $num_control)->firstOrFail();
        $usuario->permite_descarga_constancia = !$usuario->permite_descarga_constancia;
        $usuario->save();

        $estado = $usuario->permite_descarga_constancia ? 'habilitada' : 'deshabilitada';
        return redirect()->back()->with('success', "Descarga de constancia $estado para {$usuario->nombre}.");
    }

    public function validarPublica($num_control)
    {
        $usuario = Usuario::where('num_control', $num_control)
            ->with(['historial_extraescolar' => function($q) {
                $q->where('estado', 'Aprobado');
            }])->first();

        $esValida = false;
        $folio = null;

        if ($usuario && $usuario->historial_extraescolar->count() >= 2) {
            $esValida = true;
            $year = date('Y');
            $hash = strtoupper(substr(md5($usuario->num_control . $year . 'ITSSMT-SECRET'), 0, 6));
            $folio = "EXT-{$year}-{$hash}";
        }

        return view('cpanel.constancias.validar', compact('usuario', 'esValida', 'folio'));
    }
}
