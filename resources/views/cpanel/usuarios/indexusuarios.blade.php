@extends('cpanel.plantilla')

@section('title', 'Usuarios')

{{-- DataTables CSS --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .table-usuarios thead th {
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        white-space: nowrap;
        vertical-align: middle;
    }
    .table-usuarios tbody td {
        font-size: 1rem;
        vertical-align: middle;
    }
    .badge-genero-m { background-color: #0d6efd; }
    .badge-genero-f { background-color: #d63384; }
    .badge-turno-mat { background-color: #198754; }
    .badge-turno-ves { background-color: #fd7e14; }
    .acciones-btns .btn { padding: 0.3rem 0.6rem; font-size: 0.9rem; }
    .card-header-tabla {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #fff;
        border-radius: 8px 8px 0 0;
        padding: 1rem 1.25rem;
    }
    #tabla-usuarios_wrapper .dataTables_filter input {
        border-radius: 20px;
        padding: 0.3rem 0.75rem;
        border: 1px solid #ced4da;
        font-size: 0.85rem;
    }
    #tabla-usuarios_wrapper .dataTables_length select {
        border-radius: 8px;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')

<div class="container-fluid mt-3">

    {{-- Alerta de éxito --}}
    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mdi mdi-check-circle me-2 fs-5"></i>
            <span>{{ session('ok') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tarjeta principal --}}
    <div class="card shadow-sm border-0">

        <div class="card-header-tabla d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-account-group fs-4"></i>
                <h5 class="mb-0 fw-semibold">Lista de Usuarios</h5>
                <span class="badge bg-secondary ms-1">{{ $data->count() }} registros</span>
            </div>
            <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-light fw-semibold">
                <i class="mdi mdi-plus-circle me-1"></i> Agregar Usuario
            </a>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="tabla-usuarios" class="table table-usuarios table-bordered table-hover table-sm w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>N° Control</th>
                            <th>Nombre</th>
                            <th>Ap. Paterno</th>
                            <th>Ap. Materno</th>
                            <th>Género</th>
                            <th>Turno</th>
                            <th>Correo</th>
                            <th>Carrera</th>
                            <th>Generación</th>
                            <th>Actividad</th>
                            <th>Tipo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $u)
                        <tr>
                            <td class="fw-semibold text-primary">{{ $u->num_control }}</td>
                            <td>{{ $u->nombre }}</td>
                            <td>{{ $u->apat }}</td>
                            <td>{{ $u->amat }}</td>
                            <td>
                                @if(strtolower($u->genero) === 'masculino' || strtolower($u->genero) === 'm')
                                    <span class="badge badge-genero-m">
                                        <i class="mdi mdi-gender-male me-1"></i>{{ $u->genero }}
                                    </span>
                                @else
                                    <span class="badge badge-genero-f">
                                        <i class="mdi mdi-gender-female me-1"></i>{{ $u->genero }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(strtolower($u->turno) === 'matutino' || strtolower($u->turno) === 'mat')
                                    <span class="badge badge-turno-mat">{{ $u->turno }}</span>
                                @else
                                    <span class="badge badge-turno-ves">{{ $u->turno }}</span>
                                @endif
                            </td>
                            <td style="color:#212529;">{{ $u->correo_inst }}</td>
                            <td>{{ $u->carrera }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">{{ $u->generacion }}</span>
                            </td>
                            <td class="text-center">{{ $u->actividad->nombre ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge bg-dark">{{ $u->tipo->descripcion ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center acciones-btns">
                                {{-- Editar --}}
                                <a href="{{ route('usuarios.edit', $u->num_control) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Editar usuario">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('usuarios.destroy', $u->num_control) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar al usuario {{ $u->nombre }} {{ $u->apat }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar usuario">
                                        <i class="mdi mdi-trash-can"></i>
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

{{-- DataTables JS --}}
@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabla-usuarios').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: [11] } // Columna Acciones no ordenable
            ],
            order: [[0, 'asc']]
        });
    });
</script>
@endpush
