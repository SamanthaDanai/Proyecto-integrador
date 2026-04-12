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
                            <input type="text" class="form-control" name="num_control" value="{{ $usuario->num_control }}" required>
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
                            <input type="email" class="form-control" name="correo_inst" value="{{ $usuario->correo_inst }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Carrera</label>
                            <select class="form-select" name="carrera" required>
                                <option value="">Selecciona carrera</option>
                                <option value="ISC" {{ $usuario->carrera == 'ISC' ? 'selected' : '' }}>ISC</option>
                                <option value="Electromecánica" {{ $usuario->carrera == 'Electromecánica' ? 'selected' : '' }}>Electromecánica</option>
                                <option value="Industrial" {{ $usuario->carrera == 'Industrial' ? 'selected' : '' }}>Industrial</option>
                                <option value="IGE" {{ $usuario->carrera == 'IGE' ? 'selected' : '' }}>IGE</option>
                                <option value="Ambiental" {{ $usuario->carrera == 'Ambiental' ? 'selected' : '' }}>Ambiental</option>
                                <option value="Contador" {{ $usuario->carrera == 'Contador' ? 'selected' : '' }}>Contador</option>
                                <option value="Turismo" {{ $usuario->carrera == 'Turismo' ? 'selected' : '' }}>Turismo</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Generación</label>
                            <input type="text" class="form-control" name="generacion" value="{{ $usuario->generacion }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Actividad extraescolar</label>
                            <select class="form-select" name="actividad_extraescolar">
                                <option value="">Selecciona actividad</option>
                                <option value="1" {{ $usuario->actividad_extraescolar == 1 ? 'selected' : '' }}>Escolta</option>
                                <option value="2" {{ $usuario->actividad_extraescolar == 2 ? 'selected' : '' }}>Banderolas</option>
                                <option value="3" {{ $usuario->actividad_extraescolar == 3 ? 'selected' : '' }}>Danza folclórica</option>
                                <option value="4" {{ $usuario->actividad_extraescolar == 4 ? 'selected' : '' }}>Bailes latinos</option>
                                <option value="5" {{ $usuario->actividad_extraescolar == 5 ? 'selected' : '' }}>Rondalla</option>
                                <option value="6" {{ $usuario->actividad_extraescolar == 6 ? 'selected' : '' }}>Arcilla</option>
                                <option value="7" {{ $usuario->actividad_extraescolar == 7 ? 'selected' : '' }}>Basquetbol</option>
                                <option value="8" {{ $usuario->actividad_extraescolar == 8 ? 'selected' : '' }}>Futbol</option>
                                <option value="9" {{ $usuario->actividad_extraescolar == 9 ? 'selected' : '' }}>Atletismo</option>
                                <option value="10" {{ $usuario->actividad_extraescolar == 10 ? 'selected' : '' }}>Volibol</option>
                                <option value="11" {{ $usuario->actividad_extraescolar == 11 ? 'selected' : '' }}>Beisbol</option>
                                <option value="12" {{ $usuario->actividad_extraescolar == 12 ? 'selected' : '' }}>Lenguaje de Señas</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tipo de usuario</label>
                            <select class="form-control" name="id_tipo" required>
                                <option value="">Selecciona tipo</option>
                                <option value="1" {{ $usuario->id_tipo == 1 ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ $usuario->id_tipo == 2 ? 'selected' : '' }}>Usuario</option>
                            </select>
                        </div>

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
