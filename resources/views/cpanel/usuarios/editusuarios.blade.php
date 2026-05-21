@extends('cpanel.plantilla')

@section('title','Editar Usuario')

@section('content')

    <div class="container mt-4">

        <div class="card shadow-lg border-0">
            <div class="card-body">

                <h4 class="card-title mb-4 text-center">Editar Usuario</h4>

                <form action="{{ route('usuarios.update', $usuario->num_control) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Número de control</label>
                            <input type="text" class="form-control @error('num_control') is-invalid @enderror" name="num_control" value="{{ old('num_control', $usuario->num_control) }}" required>
                            @error('num_control')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="{{ $usuario->nombre }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Apellido Paterno</label>
                            <input type="text" class="form-control" name="apat" value="{{ $usuario->apat }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Apellido Materno</label>
                            <input type="text" class="form-control" name="amat" value="{{ $usuario->amat }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Género</label>
                            <select class="form-control" name="genero" required>
                                <option value="">Selecciona género</option>
                                <option value="Femenino" {{ $usuario->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Masculino" {{ $usuario->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Turno</label>
                            <select class="form-control" name="turno" required>
                                <option value="">Selecciona turno</option>
                                <option value="Matutino" {{ $usuario->turno == 'Matutino' ? 'selected' : '' }}>Matutino</option>
                                <option value="Vespertino" {{ $usuario->turno == 'Vespertino' ? 'selected' : '' }}>Vespertino</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Correo institucional</label>
                            <input type="email" class="form-control @error('correo_inst') is-invalid @enderror" name="correo_inst" value="{{ old('correo_inst', $usuario->correo_inst) }}" pattern="^[A-Za-z][0-9]{8}@smartin\.tecnm\.mx$" title="El correo debe tener el formato: una letra, 8 números y @smartin.tecnm.mx (ej. l22240029@smartin.tecnm.mx)" required>
                            @error('correo_inst')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Carrera</label>
                            <select class="form-select" name="carrera" required>
                                <option value="">Selecciona carrera</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->nombre_carrera }}" {{ $usuario->carrera == $carrera->nombre_carrera ? 'selected' : '' }}>
                                        {{ $carrera->nombre_carrera }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Periodo Académico *</label>
                            <select class="form-select" name="generacion" required>
                                <option value="">Selecciona Periodo Académico</option>
                                <optgroup label="Periodo 1 (Enero - Junio)">
                                    <option value="Enero-junio 2025" {{ old('generacion', $usuario->generacion) == 'Enero-junio 2025' ? 'selected' : '' }}>Enero - Junio 2025</option>
                                    <option value="Enero-junio 2026" {{ old('generacion', $usuario->generacion) == 'Enero-junio 2026' ? 'selected' : '' }}>Enero - Junio 2026</option>
                                    <option value="Enero-junio 2027" {{ old('generacion', $usuario->generacion) == 'Enero-junio 2027' ? 'selected' : '' }}>Enero - Junio 2027</option>
                                </optgroup>
                                <optgroup label="Periodo 2 (Agosto - Diciembre)">
                                    <option value="Agosto-diciembre 2024" {{ old('generacion', $usuario->generacion) == 'Agosto-diciembre 2024' ? 'selected' : '' }}>Agosto - Diciembre 2024</option>
                                    <option value="Agosto-diciembre 2025" {{ old('generacion', $usuario->generacion) == 'Agosto-diciembre 2025' ? 'selected' : '' }}>Agosto - Diciembre 2025</option>
                                    <option value="Agosto-diciembre 2026" {{ old('generacion', $usuario->generacion) == 'Agosto-diciembre 2026' ? 'selected' : '' }}>Agosto - Diciembre 2026</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Actividad extraescolar</label>
                            <select class="form-select" name="actividad_extraescolar">
                                <option value="">Selecciona actividad</option>
                                @foreach($actividades as $actividad)
                                    <option value="{{ $actividad->id_act }}" {{ $usuario->actividad_extraescolar == $actividad->id_act ? 'selected' : '' }}>
                                        {{ $actividad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- El tipo de usuario se mantiene automáticamente como Estudiante --}}

                        <div class="col-md-4 mb-3">
                            <label>Nueva contraseña (dejar vacío para mantener la actual)</label>
                            <input type="password" class="form-control" name="contrasena">
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
