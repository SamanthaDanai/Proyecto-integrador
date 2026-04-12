@extends('cpanel.plantilla')

@section('title', 'Agregar Docente')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
                    <h5 class="mb-0"><i class="mdi mdi-teach me-2"></i>Registrar Nuevo Docente</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('docentes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="no_empleado" class="form-label fw-semibold">Número de Empleado *</label>
                                <input type="text" class="form-control" id="no_empleado" name="no_empleado" value="{{ old('no_empleado') }}" required>
                                @error('no_empleado') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="genero" class="form-label fw-semibold">Género *</label>
                                <select class="form-select" id="genero" name="genero" required>
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('genero') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="nombre" class="form-label fw-semibold">Nombre(s) *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="apet" class="form-label fw-semibold">Apellido Paterno *</label>
                                <input type="text" class="form-control" id="apet" name="apet" value="{{ old('apet') }}" required>
                                @error('apet') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="amat" class="form-label fw-semibold">Apellido Materno *</label>
                                <input type="text" class="form-control" id="amat" name="amat" value="{{ old('amat') }}" required>
                                @error('amat') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="perfil" class="form-label fw-semibold">Perfil Profesional / Área</label>
                            <input type="text" class="form-control" id="perfil" name="perfil" value="{{ old('perfil') }}" placeholder="Ej. Ingeniero en Sistemas / Programación">
                            @error('perfil') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="fotografia" class="form-label fw-semibold">Fotografía</label>
                            <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/png, image/jpeg, image/webp">
                            <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP (Máx. 2MB).</small>
                            @error('fotografia') <div class="text-danger mt-1"><small>{{ $message }}</small></div> @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4 border-top pt-3">
                            <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Guardar Docente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
