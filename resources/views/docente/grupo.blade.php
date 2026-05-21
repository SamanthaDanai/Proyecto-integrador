@extends('layouts.docente')

@section('title', 'Grupo: ' . $actividad->nombre)

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Navegación superior -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('docente.index') }}" class="text-teal fw-bold">Dashboard</a></li>
                <li class="breadcrumb-item active fw-bold">{{ $actividad->nombre }}</li>
            </ol>
        </nav>

        <!-- Cabecera de Grupo con Contador Prominente -->
        <div class="card-custom mb-4" style="background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-teal) 100%); color: white; border-radius: 30px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-1">{{ $actividad->nombre }}</h1>
                    <p class="fs-5 opacity-75 mb-0"><i class="mdi mdi-clock-outline me-2"></i> {{ $actividad->horario }} | <i class="mdi mdi-map-marker-outline me-2"></i> Campus ITSSMT</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <div class="d-inline-block p-4 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-25 shadow-sm">
                        <div class="fs-1 fw-800 lh-1">{{ $inscritos->count() }}</div>
                        <div class="small fw-bold text-uppercase opacity-75">Alumnos Inscritos</div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 rounded-4 fw-bold p-3">
                <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de Gestión de Alumnos -->
        <div class="card-custom">
            <h4 class="fw-bold mb-4 text-navy"><i class="mdi mdi-format-list-bulleted text-teal"></i> Lista de Control de Calificaciones</h4>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3">Estudiante</th>
                            <th class="py-3">Carrera y Contacto</th>
                            <th class="py-3 text-center">P1</th>
                            <th class="py-3 text-center">P2</th>
                            <th class="py-3 text-center">P3</th>
                            <th class="py-3 text-center">Promedio</th>
                            <th class="py-3 text-center">Estatus</th>
                            <th class="py-3 text-end px-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscritos as $historial)
                            <tr>
                                <td class="px-3">
                                    <div class="fw-bold text-navy fs-5">{{ $historial->usuario->nombre }} {{ $historial->usuario->apat }}</div>
                                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.8rem;">ID: {{ $historial->usuario->num_control }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-teal small">{{ $historial->usuario->carrera }}</div>
                                    <div class="small text-muted">{{ $historial->usuario->correo_inst }}</div>
                                </td>
                                </td>
                                @php
                                    $p1 = $historial->parciales->where('num_parcial', 1)->first();
                                    $p2 = $historial->parciales->where('num_parcial', 2)->first();
                                    $p3 = $historial->parciales->where('num_parcial', 3)->first();
                                @endphp
                                <td class="text-center fw-bold text-navy">
                                    {{ $p1 ? round($p1->calificacion) : '-' }}
                                    @if($actividad->parcial1_cerrado) <i class="mdi mdi-lock text-muted small" title="Cerrado"></i> @endif
                                </td>
                                <td class="text-center fw-bold text-navy">
                                    {{ $p2 ? round($p2->calificacion) : '-' }}
                                    @if($actividad->parcial2_cerrado) <i class="mdi mdi-lock text-muted small" title="Cerrado"></i> @endif
                                </td>
                                <td class="text-center fw-bold text-navy">
                                    {{ $p3 ? round($p3->calificacion) : '-' }}
                                    @if($actividad->parcial3_cerrado) <i class="mdi mdi-lock text-muted small" title="Cerrado"></i> @endif
                                </td>
                                <td class="text-center">
                                    <span class="fs-4 fw-800 {{ $historial->calificacion_final >= 70 ? 'text-success' : ($historial->calificacion_final > 0 ? 'text-danger' : 'text-warning') }}">
                                        {{ $historial->calificacion_final !== null ? round($historial->calificacion_final) : '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($historial->estado == 'Aprobado')
                                        <span class="badge bg-success rounded-pill px-3 py-2 fw-bold shadow-sm mb-1"><i class="mdi mdi-check-circle-outline me-1"></i> APROBADO</span>
                                    @elseif($historial->estado == 'Reprobado')
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold shadow-sm mb-1"><i class="mdi mdi-close-circle-outline me-1"></i> REPROBADO</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold shadow-sm mb-1"><i class="mdi mdi-progress-clock me-1"></i> CURSANDO</span>
                                    @endif

                                    <div class="mt-1">
                                        @if($historial->firma_estudiante)
                                            <span class="badge bg-primary px-2" style="font-size: 0.7rem;"><i class="mdi mdi-pen"></i> Firmado</span>
                                        @endif
                                        @if($historial->validacion_admin)
                                            <span class="badge bg-dark px-2" style="font-size: 0.7rem;"><i class="mdi mdi-shield-check"></i> Validado</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end px-3">
                                    <div class="btn-group">
                                        @if($historial->validacion_admin || $historial->firma_estudiante)
                                            <button class="btn btn-secondary btn-sm px-3 rounded-3 me-2 fw-bold shadow-sm" title="Calificación Cerrada (Validada o Firmada)" disabled>
                                                <i class="mdi mdi-lock me-1"></i> Cerrado
                                            </button>
                                        @else
                                            <button class="btn btn-navy btn-sm px-3 rounded-3 me-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#calificarModal{{ $historial->id_historial }}">
                                                <i class="mdi mdi-pencil-box-multiple me-1"></i> Calificar
                                            </button>
                                        @endif
                                        
                                        <button class="btn btn-light btn-sm px-3 rounded-3 disabled text-muted border" title="Solo administradores pueden emitir">
                                            <i class="mdi mdi-lock-outline"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal de Calificación (Reutilizado con Mejor Estilo) -->
                            <div class="modal fade" id="calificarModal{{ $historial->id_historial }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                                        <div class="modal-header bg-navy text-white p-4" style="border-radius: 25px 25px 0 0;">
                                            <h5 class="modal-title fw-bold">Gestión de Calificación</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('docente.guardarParcial', $actividad->id_act) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="text-center mb-4 pb-3 border-bottom">
                                                    <h6 class="text-muted text-uppercase small fw-800 mb-1">Estudiante</h6>
                                                    <div class="fs-4 fw-800 text-navy">{{ $historial->usuario->nombre }} {{ $historial->usuario->apat }}</div>
                                                    <div class="small text-teal fw-bold">ID: {{ $historial->usuario->num_control }} | {{ $historial->numero_periodo }}° Periodo</div>
                                                </div>

                                                <input type="hidden" name="id_historial" value="{{ $historial->id_historial }}">
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-sm mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-muted small fw-800">PARCIAL</th>
                                                                <th class="text-muted small fw-800 text-center">ASISTENCIA %</th>
                                                                <th class="text-muted small fw-800 text-center">PARTICIPACIÓN</th>
                                                                <th class="text-muted small fw-800 text-center">CALIFICACIÓN</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach([1, 2, 3] as $num)
                                                                @php
                                                                    $parcial = $historial->parciales->where('num_parcial', $num)->first();
                                                                    $campoCerrado = 'parcial' . $num . '_cerrado';
                                                                    $esCerrado = $actividad->$campoCerrado;
                                                                @endphp
                                                                <tr class="{{ $esCerrado ? 'table-secondary' : '' }}">
                                                                    <td class="align-middle fw-bold text-navy">
                                                                        Parcial {{ $num }}
                                                                        @if($esCerrado)
                                                                            <span class="badge bg-secondary ms-1"><i class="mdi mdi-lock"></i> Cerrado</span>
                                                                        @endif
                                                                        <input type="hidden" name="parciales[{{ $num }}][num_parcial]" value="{{ $num }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control bg-light border-0 text-center fw-bold input-asistencia" data-parcial="{{ $num }}" name="parciales[{{ $num }}][asistencia]" min="0" max="100" value="{{ isset($parcial->asistencia) ? round($parcial->asistencia) : '' }}" placeholder="0" {{ $esCerrado ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control bg-light border-0 text-center fw-bold input-participacion" data-parcial="{{ $num }}" name="parciales[{{ $num }}][participacion]" min="0" max="100" value="{{ isset($parcial->participacion) ? round($parcial->participacion) : '' }}" placeholder="0" {{ $esCerrado ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control border-2 border-teal bg-white text-center fw-bold text-teal input-calificacion" id="calif_{{ $historial->id_historial }}_{{ $num }}" name="parciales[{{ $num }}][calificacion]" value="{{ isset($parcial->calificacion) ? round($parcial->calificacion) : '' }}" placeholder="0" readonly tabindex="-1" {{ $esCerrado ? 'disabled' : '' }}>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-4 pt-0">
                                                <button type="button" class="btn btn-light px-4 py-2 rounded-3 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn-green px-4 py-2 rounded-3 shadow-sm fw-bold">
                                                    <i class="mdi mdi-content-save"></i> Guardar Calificación
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="mdi mdi-account-group-outline fs-1 text-muted opacity-20"></i>
                                    <p class="fs-5 text-muted mt-3 fw-bold">Aún no hay alumnos inscritos en este grupo.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calcularCalificacion = (row) => {
        const inputAsistencia = row.querySelector('.input-asistencia');
        const inputParticipacion = row.querySelector('.input-participacion');
        const inputCalificacion = row.querySelector('.input-calificacion');
        
        if(inputAsistencia && inputParticipacion && inputCalificacion) {
            let ast = parseFloat(inputAsistencia.value) || 0;
            let part = parseFloat(inputParticipacion.value) || 0;
            
            // Si el usuario ingresó algo en cualquiera de los dos, calculamos
            if(inputAsistencia.value !== '' || inputParticipacion.value !== '') {
                let calif = (ast * 0.8) + (part * 0.2);
                inputCalificacion.value = Math.round(calif);
            } else {
                inputCalificacion.value = ''; // Limpiar si ambos están vacíos
            }
        }
    };

    document.querySelectorAll('.input-asistencia, .input-participacion').forEach(input => {
        input.addEventListener('input', function() {
            calcularCalificacion(this.closest('tr'));
        });
    });
});
</script>
@endpush

@endsection
