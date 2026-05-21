@extends('layouts.docente')

@section('title', 'Horarios y Logística')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card-custom">
            <h2 class="fw-bold mb-2"><i class="mdi mdi-clock-edit text-teal"></i> Logística de los Sábados</h2>
            <p class="text-muted fs-5 mb-5">Las actividades se imparten los sábados de 07:00 a 15:00. Define el lugar y los materiales necesarios.</p>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 rounded-4 p-3 fw-bold">
                    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($actividades->count() > 0)
                <div class="row g-4">
                    @foreach($actividades as $act)
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 25px; background: #fff;">
                                <div class="card-header bg-navy text-white p-4 border-0">
                                    <h4 class="fw-bold mb-0">{{ $act->nombre }}</h4>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="p-3 bg-light rounded-4 text-center">
                                                <i class="mdi mdi-calendar-clock fs-2 text-teal mb-2 d-block"></i>
                                                <div class="small fw-bold text-muted text-uppercase">Horario Sábado</div>
                                                <div class="fs-6 fw-bold text-navy">{{ $act->horario ?? 'Pendiente' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 bg-light rounded-4 text-center">
                                                <i class="mdi mdi-map-marker-radius fs-2 text-teal mb-2 d-block"></i>
                                                <div class="small fw-bold text-muted text-uppercase">Área / Salón</div>
                                                <div class="fs-6 fw-bold text-navy">{{ $act->lugar ?? 'Sin asignar' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="fw-bold text-muted small text-uppercase mb-2"><i class="mdi mdi-toolbox-outline me-1"></i> Materiales Requeridos</label>
                                        <div class="p-3 bg-light rounded-4 text-navy small" style="min-height: 80px;">
                                            {{ $act->materiales ?? 'No se han especificado materiales para esta actividad.' }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="mdi mdi-calendar-remove-outline fs-1 text-muted opacity-30"></i>
                    <p class="fs-4 text-muted mt-3 fw-bold">No tienes actividades asignadas actualmente.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
