@extends('layouts.docente')

@section('title', 'Gestión de Eventos')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><i class="mdi mdi-calendar-star text-teal"></i> Gestión de Eventos</h2>
                    <p class="text-muted fs-5 mb-0">Crea y administra los eventos institucionales.</p>
                </div>
                <button class="btn-green shadow-sm" data-bs-toggle="modal" data-bs-target="#crearEventoModal">
                    <i class="mdi mdi-plus-circle me-1"></i> Nuevo Evento
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 rounded-4">
                    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($eventos->count() > 0)
                <div class="row g-4">
                    @foreach($eventos as $evento)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm position-relative" style="border-radius: 20px; background: #f8fafc;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="badge bg-navy px-3 py-2 rounded-3">{{ $evento->area->nombre ?? 'General' }}</div>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                                <i class="mdi mdi-dots-vertical fs-4"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 12px;">
                                                <li><a class="dropdown-item fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#editEventoModal{{ $evento->id_actividad }}"><i class="mdi mdi-pencil text-teal me-2"></i> Editar</a></li>
                                                <li>
                                                    <form action="{{ route('docente.eventos.eliminar', $evento->id_actividad) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger fw-bold" onclick="return confirm('¿Eliminar este evento?')"><i class="mdi mdi-delete me-2"></i> Eliminar</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h5 class="fw-bold text-navy mb-3 fs-4">{{ $evento->nombre }}</h5>
                                    <p class="text-muted small mb-4" style="min-height: 50px; font-size: 1rem;">{{ $evento->descripcion ?? 'Sin descripción.' }}</p>
                                    
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="mdi mdi-clock-outline text-teal"></i>
                                        <span class="fw-bold text-navy">{{ $evento->horario ?? 'Pendiente' }}</span>
                                    </div>

                                    <div class="mt-4 pt-3 border-top d-flex gap-2">
                                        <a href="{{ route('docente.eventos.pdf', $evento->id_actividad) }}" target="_blank" class="btn btn-outline-danger btn-sm w-50 fw-bold rounded-3">
                                            <i class="mdi mdi-file-pdf-box"></i> PDF
                                        </a>
                                        <a href="{{ route('docente.eventos.excel', $evento->id_actividad) }}" class="btn btn-outline-success btn-sm w-50 fw-bold rounded-3">
                                            <i class="mdi mdi-file-excel"></i> Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Evento -->
                        <div class="modal fade" id="editEventoModal{{ $evento->id_actividad }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-header bg-navy text-white p-4" style="border-radius: 20px 20px 0 0;">
                                        <h5 class="modal-title fw-bold">Editar Evento</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('docente.eventos.actualizar', $evento->id_actividad) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted text-uppercase">Nombre del Evento</label>
                                                <input type="text" class="form-control border-0 bg-light py-3 rounded-4 fw-bold" name="nombre" value="{{ $evento->nombre }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small text-muted text-uppercase">Descripción</label>
                                                <textarea class="form-control border-0 bg-light py-3 rounded-4" name="descripcion" rows="3">{{ $evento->descripcion }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small text-muted text-uppercase">Horario</label>
                                                    <input type="text" class="form-control border-0 bg-light py-3 rounded-4" name="horario" value="{{ $evento->horario }}" placeholder="Ej. Lunes 10:00">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small text-muted text-uppercase">Área</label>
                                                    <select class="form-select border-0 bg-light py-3 rounded-4" name="id_area" required>
                                                        @foreach($areas as $area)
                                                            <option value="{{ $area->id_area }}" {{ $evento->id_area == $area->id_area ? 'selected' : '' }}>{{ $area->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="button" class="btn btn-light px-4 py-2 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn-green px-4 py-2 rounded-3 shadow-sm">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="mdi mdi-calendar-remove-outline fs-1 text-muted opacity-30"></i>
                    <p class="fs-4 text-muted mt-3">No hay eventos registrados.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Crear Evento -->
<div class="modal fade" id="crearEventoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-navy text-white p-4" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">Nuevo Evento Institucional</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('docente.eventos.guardar') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Nombre del Evento</label>
                        <input type="text" class="form-control border-0 bg-light py-3 rounded-4 fw-bold" name="nombre" required placeholder="Ej. Expo Ciencia 2024">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Descripción</label>
                        <textarea class="form-control border-0 bg-light py-3 rounded-4" name="descripcion" rows="3" placeholder="Detalles del evento..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Horario</label>
                            <input type="text" class="form-control border-0 bg-light py-3 rounded-4" name="horario" placeholder="Ej. Martes 09:00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Área</label>
                            <select class="form-select border-0 bg-light py-3 rounded-4" name="id_area" required>
                                <option value="" disabled selected>Selecciona...</option>
                                @foreach($areas as $area)
                                                                    <option value="{{ $area->id_area }}">{{ $area->nombre }}</option>
                                                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 py-2 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-green px-4 py-2 rounded-3 shadow-sm">Crear Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    select.form-select {
        color: #1e293b !important;
    }
    select.form-select option {
        color: #1e293b !important;
        background-color: #ffffff !important;
    }
</style>
@endpush
@endsection
