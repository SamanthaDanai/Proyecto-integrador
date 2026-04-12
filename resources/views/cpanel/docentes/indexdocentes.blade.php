@extends('cpanel.plantilla')

@section('title', 'Docentes')

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
    .docente-foto {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #e9ecef;
    }
    .badge-genero-m { background-color: #0d6efd; }
    .badge-genero-f { background-color: #d63384; }
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
                <i class="mdi mdi-teach fs-4"></i>
                <h5 class="mb-0 fw-semibold">Catálogo de Docentes</h5>
                <span class="badge bg-secondary ms-1">{{ count($data) }} registrados</span>
            </div>
            <a href="{{ route('docentes.create') }}" class="btn btn-sm btn-light fw-semibold">
                <i class="mdi mdi-plus-circle me-1"></i> Agregar Docente
            </a>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="tabla-docentes" class="table table-custom table-bordered table-hover table-sm w-100">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Foto</th>
                            <th>No. Emp.</th>
                            <th>Nombre Completo</th>
                            <th class="text-center">Género</th>
                            <th>Perfil / Área</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td class="text-center">
                                @if($d->fotografia)
                                    <img src="{{ asset('storage/' . $d->fotografia) }}" alt="Foto" class="docente-foto shadow-sm">
                                @else
                                    <div class="docente-foto bg-light d-flex align-items-center justify-content-center text-secondary mx-auto">
                                        <i class="mdi mdi-account"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold text-primary" style="width: 100px;">{{ $d->no_empleado }}</td>
                            <td>{{ $d->nombre }} {{ $d->apet }} {{ $d->amat }}</td>
                            <td class="text-center">
                                @if($d->genero == 'Masculino')
                                    <span class="badge badge-genero-m">Masculino</span>
                                @else
                                    <span class="badge badge-genero-f">Femenino</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ Str::limit($d->perfil, 30) }}</td>
                            <td class="text-center acciones-btns">
                                {{-- Editar --}}
                                <a href="{{ route('docentes.edit', $d->no_empleado) }}" class="btn btn-warning btn-sm" title="Editar Docente">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('docentes.destroy', $d->no_empleado) }}" method="POST" class="d-inline-block"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar al docente {{ $d->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Eliminar Docente">
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
        $('#tabla-docentes').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-MX.json'
            },
            columnDefs: [
                { orderable: false, targets: [0, 5] } 
            ],
            order: [[2, 'asc']]
        });
    });
</script>
@endpush
