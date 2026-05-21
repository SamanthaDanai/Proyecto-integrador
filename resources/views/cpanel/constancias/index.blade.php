@extends('cpanel.plantilla')

@section('title', 'Expedición de Constancias')

@push('styles')
<style>
    body {
        background-color: #f1f5f9 !important;
    }
    .card-constancia {
        background: white;
        border-radius: 30px;
        padding: 3rem;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .table-custom {
        font-size: 1.1rem;
    }
    .table-custom thead th {
        background-color: var(--color-navy);
        color: white;
        border: none;
        padding: 1.2rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }
    .table-custom tbody td {
        padding: 1.5rem 1.2rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: var(--color-navy);
    }
    .badge-periodo {
        background: #f8fafc;
        color: #1F364A;
        border: 1.5px solid #e2e8f0;
        padding: 0.6rem 1rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        display: block;
        margin-bottom: 8px;
    }
    .btn-pdf {
        background-color: #ef4444;
        color: white;
        border-radius: 15px;
        padding: 0.8rem 1.5rem;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-pdf:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    
    <div class="card-constancia">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="fw-800 text-navy mb-1"><i class="mdi mdi-certificate text-teal me-2"></i> Expedición de Constancias</h1>
                <p class="text-muted fs-5 mb-0">Alumnos elegibles con créditos de extraescolares completados (1.0 Crédito).</p>
            </div>
            <div class="text-end">
                <span class="badge bg-teal px-4 py-2 rounded-pill fs-6">{{ $usuariosLiberados->count() }} Alumnos Listos</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4 rounded-4 fw-bold">
                <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-4 fw-bold">
                <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th class="rounded-start">N° Control</th>
                        <th>Estudiante</th>
                        <th>Carrera</th>
                        <th>Evidencia de Acreditación</th>
                        <th class="text-center">Impresiones</th>
                        <th class="text-center rounded-end">Documento</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuariosLiberados as $usuario)
                        <tr>
                            <td class="fw-800 text-teal">{{ $usuario->num_control }}</td>
                            <td>
                                <div class="fw-bold text-navy fs-5">{{ $usuario->nombre }} {{ $usuario->apat }} {{ $usuario->amat }}</div>
                                <div class="small text-muted">Acreditación Completa</div>
                            </td>
                            <td class="fw-bold text-muted small">{{ $usuario->carrera }}</td>
                            <td>
                                @if(isset($usuario->historial_extraescolar[0]))
                                    <div class="badge-periodo">
                                        <i class="mdi mdi-numeric-1-circle text-teal me-1"></i> 
                                        {{ $usuario->historial_extraescolar[0]->actividadExtraescolar->nombre ?? 'Actividad 1' }} 
                                        ({{ $usuario->historial_extraescolar[0]->calificacion_final }})
                                    </div>
                                @endif
                                @if(isset($usuario->historial_extraescolar[1]))
                                    <div class="badge-periodo">
                                        <i class="mdi mdi-numeric-2-circle text-teal me-1"></i> 
                                        {{ $usuario->historial_extraescolar[1]->actividadExtraescolar->nombre ?? 'Actividad 2' }} 
                                        ({{ $usuario->historial_extraescolar[1]->calificacion_final }})
                                    </div>
                                @endif
                            </td>
                            <td class="text-center fw-bold">
                                @if($usuario->impresiones_constancia >= 2)
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="mdi mdi-lock-outline me-1"></i> 2 / 2 (Límite)</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="mdi mdi-printer me-1"></i> {{ $usuario->impresiones_constancia ?? 0 }} / 2</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('constancias.pdf', $usuario->num_control) }}" target="_blank" class="btn-pdf shadow-sm w-100 justify-content-center mb-2">
                                    <i class="mdi mdi-file-pdf-box fs-5"></i> Emitir PDF
                                </a>

                                <form action="{{ route('constancias.toggleDescarga', $usuario->num_control) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm w-100 {{ $usuario->permite_descarga_constancia ? 'btn-outline-danger' : 'btn-outline-success' }}" title="{{ $usuario->permite_descarga_constancia ? 'Deshabilitar descarga para el alumno' : 'Habilitar descarga para el alumno' }}">
                                        <i class="mdi {{ $usuario->permite_descarga_constancia ? 'mdi-cancel' : 'mdi-check-circle' }}"></i>
                                        {{ $usuario->permite_descarga_constancia ? 'Bloquear Estudiante' : 'Permitir Estudiante' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="mdi mdi-account-search-outline fs-1 text-muted opacity-20"></i>
                                <p class="fs-4 text-muted mt-3 fw-bold">No hay alumnos con los 2 periodos acreditados aún.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
