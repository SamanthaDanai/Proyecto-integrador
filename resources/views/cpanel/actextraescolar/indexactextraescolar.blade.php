@extends('cpanel.plantilla')

@section('title', 'Actividades Extraescolares')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .table-custom thead th {
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        white-space: nowrap;
        vertical-align: middle;
    }
    .table-custom tbody td {
        font-size: 1rem;
        vertical-align: middle;
    }
    .acciones-btns .btn { padding: 0.3rem 0.6rem; font-size: 0.9rem; margin: 0 0.1rem;}
    .card-header-tabla {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #fff;
        border-radius: 8px 8px 0 0;
        padding: 1rem 1.25rem;
    }
    #tabla-actividades_wrapper .dataTables_filter input {
        border-radius: 20px;
        padding: 0.3rem 0.75rem;
        border: 1px solid #ced4da;
        font-size: 0.85rem;
    }
    #tabla-actividades_wrapper .dataTables_length select {
        border-radius: 8px;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')

<div class="container-fluid mt-3">

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mdi mdi-check-circle me-2 fs-5"></i>
            <span>{{ session('ok') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header-tabla d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-calendar-blank-multiple fs-4"></i>
                <h5 class="mb-0 fw-semibold">Lista de Actividades Extraescolares</h5>
                <span class="badge bg-secondary ms-1">{{ count($data) }} registros</span>
            </div>
            <a href="{{ route('actextraescolar.create') }}" class="btn btn-sm btn-light fw-semibold">
                <i class="mdi mdi-plus-circle me-1"></i> Agregar Actividad
            </a>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="tabla-actividades" class="table table-custom table-bordered table-hover table-sm w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>N°/ID</th>
                            <th>Nombre de la Actividad</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $act)
                        <tr>
                            <td class="fw-semibold text-primary text-center" style="width: 80px;">{{ $act->id_act }}</td>
                            <td>{{ $act->nombre }}</td>
                            <td class="text-center">
                                @if($act->activo)
                                    <span class="badge bg-success"><i class="mdi mdi-check-circle-outline me-1"></i>Activo</span>
                                @else
                                    <span class="badge bg-danger"><i class="mdi mdi-close-circle-outline me-1"></i>Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center acciones-btns">
                                {{-- Activar/Desactivar --}}
                                <form action="{{ route('actextraescolar.toggle', $act->id_act) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button class="btn btn-{{ $act->activo ? 'secondary' : 'success' }} btn-sm" title="{{ $act->activo ? 'Deshabilitar' : 'Habilitar' }}">
                                        <i class="mdi mdi-power"></i>
                                    </button>
                                </form>

                                {{-- Editar --}}
                                <a href="{{ route('actextraescolar.edit', $act->id_act) }}"
                                   class="btn btn-warning btn-sm" title="Editar actividad">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('actextraescolar.destroy', $act->id_act) }}"
                                      method="POST" class="d-inline-block"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar la actividad {{ $act->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Eliminar actividad">
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

@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabla-actividades').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: [3] } 
            ],
            order: [[0, 'asc']]
        });
    });
</script>
@endpush
