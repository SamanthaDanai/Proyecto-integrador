@extends('cpanel.plantilla')

@section('title', 'Grupos y Horarios')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
            <h4 class="card-title fw-bold text-dark mb-0"><i class="mdi mdi-map-marker-radius me-2 text-primary"></i> Gestión de Eventos</h4>
            <a href="{{ route('actividades.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="mdi mdi-plus me-1"></i> Nuevo Evento
            </a>
        </div>
        
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold text-secondary"># ID</th>
                            <th class="fw-semibold text-secondary">Nombre del Evento</th>
                            <th class="fw-semibold text-secondary">Horario</th>
                            <th class="fw-semibold text-secondary">Lugar / Área</th>
                            <th class="fw-semibold text-secondary">Responsable</th>
                            <th class="fw-semibold text-secondary text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($actividades as $actividad)
                            <tr>
                                <td class="text-muted fw-bold">{{ $actividad->id_actividad }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $actividad->nombre }}</span>
                                    <br>
                                    <small class="text-muted">{{ $actividad->descripcion }}</small>
                                </td>
                                <td><span class="badge bg-info text-dark rounded-pill px-3">{{ $actividad->horario ?? 'Por definir' }}</span></td>
                                <td><span class="badge bg-secondary rounded-pill px-3"><i class="mdi mdi-map-marker"></i> {{ $actividad->area ? $actividad->area->nombre : 'Sin asignar' }}</span></td>
                                <td>
                                    @if($actividad->docentes && $actividad->docentes->count() > 0)
                                        <div class="d-flex align-items-center">
                                            @if($actividad->docentes->first()->fotografia)
                                                <img src="{{ Storage::url('docentes/'.$actividad->docentes->first()->fotografia) }}" class="rounded-circle me-2 object-fit-cover" width="32" height="32" alt="Foto">
                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width:32px; height:32px;"><i class="mdi mdi-account"></i></div>
                                            @endif
                                            <span>{{ $actividad->docentes->first()->nombre }} {{ $actividad->docentes->first()->apet }}</span>
                                        </div>
                                    @else
                                        <span class="text-danger"><i class="mdi mdi-alert-circle-outline"></i> Sin asignar</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('docente.eventos.pdf', $actividad->id_actividad) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3 me-1" title="Exportar PDF de Participantes">
                                        <i class="mdi mdi-file-pdf-box"></i> PDF
                                    </a>
                                    <a href="{{ route('docente.eventos.excel', $actividad->id_actividad) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 me-1" title="Exportar Excel de Participantes">
                                        <i class="mdi mdi-file-excel"></i> Excel
                                    </a>
                                    <a href="{{ route('actividades.edit', $actividad->id_actividad) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="mdi mdi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('actividades.destroy', $actividad->id_actividad) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('¿Estás seguro de eliminar este evento?')">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="mdi mdi-clipboard-text-off-outline fs-1 d-block mb-2"></i>
                                        No hay eventos registrados actualmente.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
