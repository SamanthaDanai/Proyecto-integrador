@extends('cpanel.plantilla')

@section('title', 'Calificaciones: ' . $actividad->nombre)

@section('content')
<div class="container mt-4">

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Encabezado --}}
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="card-title text-primary mb-1">
                        <i class="mdi mdi-format-list-checks"></i> Calificaciones — {{ $actividad->nombre }}
                    </h4>
                    <span class="text-muted small">Horario: {{ $actividad->horario }} | Lugar: {{ $actividad->lugar ?? 'N/D' }}</span>
                </div>
                <a href="{{ route('actextraescolar.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    {{-- Panel de Control del Administrador --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-dark text-white fw-bold py-3">
            <i class="mdi mdi-shield-account me-2"></i> Panel de Control — Administrador
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">

                {{-- Toggle Inscripción --}}
                <div class="col-md-3">
                    <div class="p-3 rounded-3 border text-center {{ $actividad->inscripcion_abierta ? 'border-success bg-success bg-opacity-10' : 'border-danger bg-danger bg-opacity-10' }}">
                        <div class="fw-bold mb-2 {{ $actividad->inscripcion_abierta ? 'text-success' : 'text-danger' }}">
                            <i class="mdi {{ $actividad->inscripcion_abierta ? 'mdi-door-open' : 'mdi-door-closed' }} fs-4"></i><br>
                            Inscripción: <strong>{{ $actividad->inscripcion_abierta ? 'ABIERTA' : 'CERRADA' }}</strong>
                        </div>
                        <form action="{{ route('actextraescolar.toggleInscripcion', $actividad->id_act) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $actividad->inscripcion_abierta ? 'btn-danger' : 'btn-success' }} fw-bold w-100"
                                onclick="return confirm('¿Confirmar cambio de estado de inscripción?')">
                                {{ $actividad->inscripcion_abierta ? 'Cerrar Inscripción' : 'Abrir Inscripción' }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Cierre Parcial 1 --}}
                @foreach([1, 2, 3] as $n)
                    @php $campo = 'parcial' . $n . '_cerrado'; $cerrado = $actividad->$campo; @endphp
                    <div class="col-md-3">
                        <div class="p-3 rounded-3 border text-center {{ $cerrado ? 'border-secondary bg-secondary bg-opacity-10' : 'border-primary bg-primary bg-opacity-10' }}">
                            <div class="fw-bold mb-2 {{ $cerrado ? 'text-secondary' : 'text-primary' }}">
                                <i class="mdi {{ $cerrado ? 'mdi-lock' : 'mdi-lock-open-variant' }} fs-4"></i><br>
                                Parcial {{ $n }}: <strong>{{ $cerrado ? 'CERRADO' : 'ABIERTO' }}</strong>
                            </div>
                            <form action="{{ route('actextraescolar.cerrarParcial', $actividad->id_act) }}" method="POST">
                                @csrf
                                <input type="hidden" name="num_parcial" value="{{ $n }}">
                                <button type="submit" class="btn btn-sm {{ $cerrado ? 'btn-outline-primary' : 'btn-outline-secondary' }} fw-bold w-100"
                                    onclick="return confirm('¿Confirmar {{ $cerrado ? 'abrir' : 'cerrar' }} Parcial {{ $n }}?')">
                                    {{ $cerrado ? '🔓 Abrir Parcial ' . $n : '🔒 Cerrar Parcial ' . $n }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- Tabla de Calificaciones --}}
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Num Control</th>
                            <th>Estudiante</th>
                            <th class="text-center">
                                P1 @if($actividad->parcial1_cerrado) <i class="mdi mdi-lock text-warning" title="Cerrado"></i> @endif
                            </th>
                            <th class="text-center">
                                P2 @if($actividad->parcial2_cerrado) <i class="mdi mdi-lock text-warning" title="Cerrado"></i> @endif
                            </th>
                            <th class="text-center">
                                P3 @if($actividad->parcial3_cerrado) <i class="mdi mdi-lock text-warning" title="Cerrado"></i> @endif
                            </th>
                            <th class="text-center">Promedio</th>
                            <th class="text-center">Estado Estudiante</th>
                            <th class="text-center">Validación Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscritos as $hist)
                            @php
                                $p1 = $hist->parciales->where('num_parcial', 1)->first();
                                $p2 = $hist->parciales->where('num_parcial', 2)->first();
                                $p3 = $hist->parciales->where('num_parcial', 3)->first();
                                $tieneCalificacion = $hist->calificacion_final !== null;
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $hist->num_control }}</td>
                                <td>{{ $hist->usuario->nombre }} {{ $hist->usuario->apat }} {{ $hist->usuario->amat }}</td>
                                <td class="text-center {{ $p1 ? '' : 'text-muted' }}">
                                    {{ $p1 ? number_format($p1->calificacion, 1) : '—' }}
                                </td>
                                <td class="text-center {{ $p2 ? '' : 'text-muted' }}">
                                    {{ $p2 ? number_format($p2->calificacion, 1) : '—' }}
                                </td>
                                <td class="text-center {{ $p3 ? '' : 'text-muted' }}">
                                    {{ $p3 ? number_format($p3->calificacion, 1) : '—' }}
                                </td>
                                <td class="text-center fw-bold {{ $tieneCalificacion ? 'text-primary' : 'text-muted' }}">
                                    {{ $tieneCalificacion ? number_format($hist->calificacion_final, 1) : '—' }}
                                </td>
                                <td class="text-center">
                                    @if($hist->firma_estudiante)
                                        <span class="badge bg-success"><i class="mdi mdi-check-decagram"></i> Firmó de Conformidad</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="mdi mdi-clock-outline"></i> Pendiente Firma</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($hist->validacion_admin)
                                        <span class="badge bg-success px-3 py-2"><i class="mdi mdi-check-all"></i> Validado</span>
                                    @elseif(!$tieneCalificacion)
                                        <span class="badge bg-secondary px-3 py-2" title="El docente aún no registra calificaciones">
                                            <i class="mdi mdi-minus-circle-outline"></i> Sin calificación
                                        </span>
                                    @else
                                        <form action="{{ route('actextraescolar.validar') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_historial" value="{{ $hist->id_historial }}">
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                onclick="return confirm('¿Confirmar validación de calificaciones para este estudiante?')">
                                                <i class="mdi mdi-check-circle-outline"></i> Aceptar Calificación
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No hay estudiantes inscritos en este grupo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
