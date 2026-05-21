@extends('cpanel.plantilla')

@section('title','Actividades Extraescolares')

@section('content')

    <div class="container mt-4">

        <div class="card shadow-lg border-0">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title text-primary"><i class="mdi mdi-calendar-check"></i> Gestión de Actividades Extraescolares</h4>
                    <a href="{{ route('actextraescolar.create') }}" class="btn btn-success">
                        <i class="mdi mdi-plus"></i> Nueva Actividad
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th># ID</th>
                                <th>Actividad</th>
                                <th>Docente</th>
                                <th>Horario</th>
                                <th>Cupos (H/M)</th>
                                <th>Estado</th>
                                <th class="text-center">Inscripción</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $act)
                                <tr>
                                    <td>{{ $act->id_act }}</td>
                                    <td class="fw-bold">{{ $act->nombre }}</td>
                                    <td>
                                        @if($act->docente)
                                            {{ $act->docente->nombre }} {{ $act->docente->apet }}
                                        @else
                                            <span class="text-danger">Sin docente</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info text-dark">{{ $act->horario }}</span></td>
                                    <td>
                                        <span class="badge bg-primary" title="Hombres">{{ $act->cupo_masculino }} H</span>
                                        <span class="badge bg-danger" title="Mujeres">{{ $act->cupo_femenino }} M</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('actextraescolar.toggle', $act->id_act) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $act->activo ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $act->activo ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('actextraescolar.toggleInscripcion', $act->id_act) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $act->inscripcion_abierta ? 'btn-success' : 'btn-danger' }}"
                                                onclick="return confirm('¿Cambiar estado de inscripción?')" title="{{ $act->inscripcion_abierta ? 'Inscripción Abierta — Click para cerrar' : 'Inscripción Cerrada — Click para abrir' }}">
                                                <i class="mdi {{ $act->inscripcion_abierta ? 'mdi-door-open' : 'mdi-door-closed' }}"></i>
                                                {{ $act->inscripcion_abierta ? 'Abierta' : 'Cerrada' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('actextraescolar.calificaciones', $act->id_act) }}" class="btn btn-info btn-sm text-white" title="Ver Calificaciones">
                                            <i class="mdi mdi-format-list-checks"></i> Calificaciones
                                        </a>
                                        <a href="{{ route('actextraescolar.edit', $act->id_act) }}" class="btn btn-primary btn-sm" title="Editar">
                                            <i class="mdi mdi-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('actextraescolar.destroy', $act->id_act) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar actividad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="mdi mdi-delete"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection
