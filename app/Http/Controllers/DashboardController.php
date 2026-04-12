<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\ActExtraescolar;
use App\Models\TipoUsuario;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('cpanel.inicio');
    }

    public function resumen()
    {
        // ── KPIs ──────────────────────────────────────────────────
        $totalUsuarios    = Usuario::count();
        $totalActividades = ActExtraescolar::count();
        $totalTipos       = TipoUsuario::count();

        // Género predominante
        $generoPred = Usuario::select('genero', DB::raw('COUNT(*) as total'))
            ->groupBy('genero')
            ->orderByDesc('total')
            ->first();

        // Turno predominante
        $turnoPred = Usuario::select('turno', DB::raw('COUNT(*) as total'))
            ->groupBy('turno')
            ->orderByDesc('total')
            ->first();

        // Actividad predominante
        $actividadPred = Usuario::join('Act_extraesc', 'usuario.actividad_extraescolar', '=', 'Act_extraesc.id_act')
            ->select('Act_extraesc.nombre as actividad_extraescolar', DB::raw('COUNT(*) as total'))
            ->groupBy('Act_extraesc.nombre')
            ->orderByDesc('total')
            ->first();

        // Carrera predominante
        $carreraPred = Usuario::select('carrera', DB::raw('COUNT(*) as total'))
            ->groupBy('carrera')
            ->orderByDesc('total')
            ->first();

        // ── Gráfica 1: Usuarios por Carrera ───────────────────────
        $porCarrera = Usuario::select('carrera', DB::raw('COUNT(*) as total'))
            ->groupBy('carrera')
            ->orderByDesc('total')
            ->get();

        // ── Gráfica 2: Usuarios por Género ────────────────────────
        $porGenero = Usuario::select('genero', DB::raw('COUNT(*) as total'))
            ->groupBy('genero')
            ->get();

        // ── Gráfica 3: Usuarios por Turno ─────────────────────────
        $porTurno = Usuario::select('turno', DB::raw('COUNT(*) as total'))
            ->groupBy('turno')
            ->get();

        // ── Gráfica 4: Usuarios por Generación ────────────────────
        $porGeneracion = Usuario::select('generacion', DB::raw('COUNT(*) as total'))
            ->groupBy('generacion')
            ->orderBy('generacion')
            ->get();

        // ── Gráfica 5: Usuarios por Tipo ──────────────────────────
        $porTipo = Usuario::join('Tipo_usuario', 'usuario.id_tipo', '=', 'Tipo_usuario.id_tipo')
            ->select('Tipo_usuario.descripcion as id_tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('Tipo_usuario.descripcion')
            ->orderBy('Tipo_usuario.descripcion')
            ->get();

        // ── Gráfica 6: Usuarios por Actividad Extraescolar ────────
        $porActividad = Usuario::join('Act_extraesc', 'usuario.actividad_extraescolar', '=', 'Act_extraesc.id_act')
            ->select('Act_extraesc.nombre as actividad_extraescolar', DB::raw('COUNT(*) as total'))
            ->groupBy('Act_extraesc.nombre')
            ->orderByDesc('total')
            ->get();

        return view('cpanel.dashboard', compact(
            'totalUsuarios',
            'totalActividades',
            'totalTipos',
            'generoPred',
            'turnoPred',
            'actividadPred',
            'carreraPred',
            'porCarrera',
            'porGenero',
            'porTurno',
            'porGeneracion',
            'porTipo',
            'porActividad'
        ));
    }
}
