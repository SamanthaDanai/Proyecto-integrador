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
    .docente-foto-modal {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .badge-genero-m { background-color: #0d6efd; }
    .badge-genero-f { background-color: #d63384; }
    .btn-no-emp {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px dashed #0d6efd;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-block;
    }
    .btn-no-emp:hover {
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
    }
    /* Estilos del modal */
    .modal-header-custom {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #fff;
        border-bottom: none;
    }
    .modal-header-custom .btn-close {
        filter: invert(1);
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
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="mdi mdi-alert-circle me-2 fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle me-2 fs-5"></i>
            <span>Hubo un error al guardar. Revisa los datos.</span>
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
                            <th class="text-center">No. Emp.</th>
                            <th>Nombre Completo</th>
                            <th>Correo Institucional</th>
                            <th class="text-center">Género</th>
                            <th>Perfil / Área</th>
                            <th class="text-center">Estado</th>
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
                            <td class="text-center" style="width: 120px;">
                                <a href="#" class="btn-no-emp" data-bs-toggle="modal" data-bs-target="#modalDocente{{ $d->no_empleado }}" title="Ver/Editar Detalles">
                                    <i class="mdi mdi-card-account-details-outline me-1"></i> {{ $d->no_empleado }}
                                </a>
                            </td>
                            <td>{{ $d->nombre }} {{ $d->apet }} {{ $d->amat }}</td>
                            <td>{{ $d->correo ?? 'Sin correo' }}</td>
                            <td class="text-center">
                                @if($d->genero == 'Masculino')
                                    <span class="badge badge-genero-m">Masculino</span>
                                @else
                                    <span class="badge badge-genero-f">Femenino</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ Str::limit($d->perfil, 30) }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    @if($d->activo)
                                        <span class="badge bg-success" style="padding: 6px 10px;"><i class="mdi mdi-check-circle-outline me-1"></i>Activo</span>
                                    @else
                                        <span class="badge bg-danger" style="padding: 6px 10px;"><i class="mdi mdi-close-circle-outline me-1"></i>Inactivo</span>
                                    @endif
                                    
                                    <form action="{{ route('docentes.toggle', $d->no_empleado) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button class="btn btn-{{ $d->activo ? 'outline-secondary' : 'success' }} btn-xs py-1 px-2" style="font-size: 0.75rem; border-radius: 4px;" title="{{ $d->activo ? 'Inactivar docente' : 'Activar docente' }}">
                                            <i class="mdi mdi-power"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal para ver/editar/eliminar Docente -->
                        <div class="modal fade" id="modalDocente{{ $d->no_empleado }}" tabindex="-1" aria-labelledby="modalDocenteLabel{{ $d->no_empleado }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow:hidden;">
                                    
                                    <div class="modal-header modal-header-custom p-4 pb-5 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="w-100 text-center mt-2">
                                            @if($d->fotografia)
                                                <img src="{{ asset('storage/' . $d->fotografia) }}" alt="Foto" class="docente-foto-modal mb-2">
                                            @else
                                                <div class="docente-foto-modal bg-light d-flex align-items-center justify-content-center text-secondary mx-auto mb-2">
                                                    <i class="mdi mdi-account fs-1"></i>
                                                </div>
                                            @endif
                                            <h4 class="mb-0 fw-bold">{{ $d->nombre }} {{ $d->apet }} {{ $d->amat }}</h4>
                                            <p class="mb-0 text-white-50"><i class="mdi mdi-identifier"></i> {{ $d->no_empleado }}</p>
                                        </div>
                                    </div>

                                    <div class="modal-body p-4 bg-light">
                                        <!-- Formulario de Edición -->
                                        <form action="{{ route('docentes.update', $d->no_empleado) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label fw-semibold">Correo Institucional *</label>
                                                    <input type="email" class="form-control" name="correo" value="{{ old('correo', $d->correo) }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Nueva Contraseña</label>
                                                    <input type="password" class="form-control" name="contrasena" placeholder="Dejar blanco para no cambiar">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <label class="form-label fw-semibold">Nombre(s) *</label>
                                                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $d->nombre) }}" required>
                                                </div>
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <label class="form-label fw-semibold">Apellido Paterno *</label>
                                                    <input type="text" class="form-control" name="apet" value="{{ old('apet', $d->apet) }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Apellido Materno *</label>
                                                    <input type="text" class="form-control" name="amat" value="{{ old('amat', $d->amat) }}" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label fw-semibold">Género *</label>
                                                    <select class="form-select" name="genero" required>
                                                        <option value="Masculino" {{ $d->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="Femenino" {{ $d->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Perfil Profesional / Area</label>
                                                    <input type="text" class="form-control" name="perfil" value="{{ old('perfil', $d->perfil) }}">
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">Actualizar Foto (Opcional)</label>
                                                <input type="file" class="form-control" name="fotografia" accept="image/png, image/jpeg, image/webp">
                                            </div>

                                            <div class="d-flex justify-content-between border-top pt-3">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Guardar Cambios</button>
                                            </div>
                                        </form>

                                        <!-- Botones de Estado y Eliminar (Formularios Separados) -->
                                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                            <form action="{{ route('docentes.toggle', $d->no_empleado) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-{{ $d->activo ? 'outline-secondary' : 'success' }}">
                                                    <i class="mdi mdi-power me-1"></i> {{ $d->activo ? 'Inactivar Docente (Historial)' : 'Activar Docente' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('docentes.destroy', $d->no_empleado) }}" method="POST" class="d-inline-block" onsubmit="return confirm('ATENCION: ¿Seguro que deseas eliminar definitivamente a este docente y su cuenta de acceso? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="mdi mdi-trash-can"></i> Eliminar Docente Definitivamente</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal -->

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
                { orderable: false, targets: [0, 6] } 
            ],
            order: [[2, 'asc']]
        });
    });
</script>
@endpush
