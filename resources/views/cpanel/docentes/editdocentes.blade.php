@extends('cpanel.plantilla')

@section('title', 'Editar Docente')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
                    <h5 class="mb-0"><i class="mdi mdi-pencil me-2"></i>Editar Datos del Docente</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('docentes.update', $docente->no_empleado) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="no_empleado_readonly" class="form-label fw-semibold text-muted">Número de Empleado (No editable)</label>
                                <input type="text" class="form-control bg-light" id="no_empleado_readonly" value="{{ $docente->no_empleado }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="genero" class="form-label fw-semibold">Género *</label>
                                <select class="form-select" id="genero" name="genero" required>
                                    <option value="Masculino" {{ $docente->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ $docente->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('genero') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="nombre" class="form-label fw-semibold">Nombre(s) *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $docente->nombre }}" required>
                                @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="apet" class="form-label fw-semibold">Apellido Paterno *</label>
                                <input type="text" class="form-control" id="apet" name="apet" value="{{ $docente->apet }}" required>
                                @error('apet') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="amat" class="form-label fw-semibold">Apellido Materno *</label>
                                <input type="text" class="form-control" id="amat" name="amat" value="{{ $docente->amat }}" required>
                                @error('amat') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="perfil" class="form-label fw-semibold">Perfil Profesional / Área</label>
                            <input type="text" class="form-control" id="perfil" name="perfil" value="{{ $docente->perfil }}" placeholder="Ej. Ingeniero en Sistemas / Programación">
                            @error('perfil') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4 row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <p class="mb-2 fw-semibold text-muted small">Foto Actual</p>
                                @if($docente->fotografia)
                                    <img src="{{ asset('storage/' . $docente->fotografia) }}" alt="Foto" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center text-secondary mx-auto border rounded-circle" style="width: 100px; height: 100px;">
                                        <i class="mdi mdi-account fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <label for="fotografia" class="form-label fw-semibold">Actualizar Fotografía (Opcional)</label>
                                <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/png, image/jpeg, image/webp">
                                <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP (Máx. 2MB). Si no subes nada, se mantendrá la foto actual.</small>
                                @error('fotografia') <div class="text-danger mt-1"><small>{{ $message }}</small></div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 border-top pt-3">
                            <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="mdi mdi-content-save"></i> Actualizar Docente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
