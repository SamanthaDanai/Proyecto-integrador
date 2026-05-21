@extends('cpanel.plantilla')

@section('title', 'Usuarios')

{{-- DataTables CSS --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .table-usuarios thead th {
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        white-space: nowrap;
        vertical-align: middle;
    }
    .table-usuarios tbody td {
        font-size: 0.95rem;
        vertical-align: middle;
    }
    .badge-genero-m { background-color: #0d6efd; }
    .badge-genero-f { background-color: #d63384; }
    .badge-turno-mat { background-color: #198754; }
    .badge-turno-ves { background-color: #fd7e14; }
    
    .card-header-tabla {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #fff;
        border-radius: 8px 8px 0 0;
        padding: 1rem 1.25rem;
    }
    
    .btn-num-control {
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
    .btn-num-control:hover {
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
    .user-avatar-modal {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle me-2 fs-5"></i>
            <span>Error al actualizar: {{ $errors->first() }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tarjeta principal --}}
    <div class="card shadow-sm border-0">

        <div class="card-header-tabla d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-account-group fs-4"></i>
                <h5 class="mb-0 fw-semibold">Lista de Usuarios</h5>
                <span class="badge bg-secondary ms-1">{{ $data->count() }} registrados</span>
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
                            <th>Nombre Completo</th>
                            <th>Género</th>
                            <th>Turno</th>
                            <th>Correo</th>
                            <th>Carrera</th>
                            <th>Periodo</th>
                            <th>Actividad</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $u)
                        <tr>
                            <td class="text-center">
                                <a href="#" class="btn-num-control" data-bs-toggle="modal" data-bs-target="#modalUsuario{{ $u->num_control }}">
                                    {{ $u->num_control }}
                                </a>
                            </td>
                            <td>{{ $u->nombre }} {{ $u->apat }} {{ $u->amat }}</td>
                            <td class="text-center">
                                @if(strtolower($u->genero) === 'masculino' || strtolower($u->genero) === 'm')
                                    <span class="badge badge-genero-m">M</span>
                                @else
                                    <span class="badge badge-genero-f">F</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(strtolower($u->turno) === 'matutino' || strtolower($u->turno) === 'mat')
                                    <span class="badge badge-turno-mat">Mat</span>
                                @else
                                    <span class="badge badge-turno-ves">Ves</span>
                                @endif
                            </td>
                            <td style="font-size: 0.85rem;">{{ $u->correo_inst }}</td>
                            <td style="font-size: 0.85rem;">{{ $u->carrera }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark" style="font-size: 0.75rem;">{{ $u->generacion }}</span>
                            </td>
                            <td class="text-center" style="font-size: 0.85rem;">{{ $u->actividad->nombre ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge bg-dark" style="font-size: 0.75rem;">{{ $u->tipo->descripcion ?? 'N/A' }}</span>
                            </td>
                        </tr>

                        <!-- Modal para ver/editar/eliminar Usuario -->
                        <div class="modal fade" id="modalUsuario{{ $u->num_control }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow:hidden;">
                                    
                                    <div class="modal-header modal-header-custom p-4 pb-5 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="w-100 text-center mt-2">
                                            @if($u->fotografia_perfil)
                                                <img src="{{ Storage::url('perfiles/' . $u->fotografia_perfil) }}" class="user-avatar-modal mb-2">
                                            @else
                                                <div class="user-avatar-modal bg-light d-flex align-items-center justify-content-center text-secondary mx-auto mb-2">
                                                    <i class="mdi mdi-account fs-1"></i>
                                                </div>
                                            @endif
                                            <h4 class="mb-0 fw-bold">{{ $u->nombre }} {{ $u->apat }} {{ $u->amat }}</h4>
                                            <p class="mb-0 text-white-50"><i class="mdi mdi-identifier"></i> {{ $u->num_control }}</p>
                                        </div>
                                    </div>

                                    <div class="modal-body p-4 bg-light">
                                        <form action="{{ route('usuarios.update', $u->num_control) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small">Número de Control *</label>
                                                    <input type="text" class="form-control form-control-sm" name="num_control" value="{{ old('num_control', $u->num_control) }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small">Nombre(s) *</label>
                                                    <input type="text" class="form-control form-control-sm" name="nombre" value="{{ $u->nombre }}" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold small">Ap. Paterno *</label>
                                                    <input type="text" class="form-control form-control-sm" name="apat" value="{{ $u->apat }}" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold small">Ap. Materno *</label>
                                                    <input type="text" class="form-control form-control-sm" name="amat" value="{{ $u->amat }}" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold small">Género *</label>
                                                    <select class="form-select form-select-sm" name="genero" required>
                                                        <option value="Femenino" {{ $u->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                        <option value="Masculino" {{ $u->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold small">Turno *</label>
                                                    <select class="form-select form-select-sm" name="turno" required>
                                                        <option value="Matutino" {{ $u->turno == 'Matutino' ? 'selected' : '' }}>Matutino</option>
                                                        <option value="Vespertino" {{ $u->turno == 'Vespertino' ? 'selected' : '' }}>Vespertino</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                    <label class="form-label fw-bold small">Correo Institucional *</label>
                                                    <input type="email" class="form-control form-control-sm" name="correo_inst" value="{{ old('correo_inst', $u->correo_inst) }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small">Carrera *</label>
                                                    <select class="form-select form-select-sm" name="carrera" required>
                                                        @foreach($carreras as $carrera)
                                                            <option value="{{ $carrera->nombre_carrera }}" {{ $u->carrera == $carrera->nombre_carrera ? 'selected' : '' }}>
                                                                {{ $carrera->nombre_carrera }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                 <div class="col-md-3 mb-3">
                                                     <label class="form-label fw-bold small">Periodo Académico *</label>
                                                     <select class="form-select form-select-sm" name="generacion" required>
                                                         <option value="">Selecciona Periodo</option>
                                                         <optgroup label="Periodo 1 (Enero - Junio)">
                                                             <option value="Enero-junio 2025" {{ old('generacion', $u->generacion) == 'Enero-junio 2025' ? 'selected' : '' }}>Enero - Junio 2025</option>
                                                             <option value="Enero-junio 2026" {{ old('generacion', $u->generacion) == 'Enero-junio 2026' ? 'selected' : '' }}>Enero - Junio 2026</option>
                                                             <option value="Enero-junio 2027" {{ old('generacion', $u->generacion) == 'Enero-junio 2027' ? 'selected' : '' }}>Enero - Junio 2027</option>
                                                         </optgroup>
                                                         <optgroup label="Periodo 2 (Agosto - Diciembre)">
                                                             <option value="Agosto-diciembre 2024" {{ old('generacion', $u->generacion) == 'Agosto-diciembre 2024' ? 'selected' : '' }}>Agosto - Diciembre 2024</option>
                                                             <option value="Agosto-diciembre 2025" {{ old('generacion', $u->generacion) == 'Agosto-diciembre 2025' ? 'selected' : '' }}>Agosto - Diciembre 2025</option>
                                                             <option value="Agosto-diciembre 2026" {{ old('generacion', $u->generacion) == 'Agosto-diciembre 2026' ? 'selected' : '' }}>Agosto - Diciembre 2026</option>
                                                         </optgroup>
                                                     </select>
                                                 </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label fw-bold small">Tipo Usuario *</label>
                                                    <select class="form-select form-select-sm" name="id_tipo" required>
                                                        @foreach($tipos as $tipo)
                                                            <option value="{{ $tipo->id_tipo }}" {{ $u->id_tipo == $tipo->id_tipo ? 'selected' : '' }}>
                                                                {{ $tipo->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small">Actividad Extraescolar</label>
                                                    <select class="form-select form-select-sm" name="actividad_extraescolar">
                                                        <option value="">Ninguna</option>
                                                        @foreach($actividades as $actividad)
                                                            <option value="{{ $actividad->id_act }}" {{ $u->actividad_extraescolar == $actividad->id_act ? 'selected' : '' }}>
                                                                {{ $actividad->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold small">Nueva Contraseña</label>
                                                    <input type="password" class="form-control form-control-sm" name="contrasena" placeholder="Vacío para no cambiar">
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between border-top pt-3">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="mdi mdi-content-save"></i> Guardar Cambios</button>
                                            </div>
                                        </form>

                                        <div class="mt-3 text-end">
                                            <form action="{{ route('usuarios.destroy', $u->num_control) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar definitivamente a este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs text-danger border-0 bg-transparent p-0 small">
                                                    <i class="mdi mdi-trash-can"></i> Eliminar Usuario
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                { orderable: false, targets: [] } 
            ],
            order: [[0, 'asc']]
        });
    });
</script>
@endpush

