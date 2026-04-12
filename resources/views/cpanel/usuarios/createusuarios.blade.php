@extends('cpanel.plantilla')

@section('title','Crear Usuario')

@section('content')

    <div class="container mt-4">

        <div class="card shadow-lg border-0">
            <div class="card-body">

                <h4 class="card-title mb-4 text-center">Crear Usuario</h4>

                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Número de control</label>
                            <input type="text" class="form-control" name="num_control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Apellido Paterno</label>
                            <input type="text" class="form-control" name="apat" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Apellido Materno</label>
                            <input type="text" class="form-control" name="amat" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Género</label>
                            <select class="form-control" name="genero" required>
                                <option value="">Selecciona género</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Masculino">Masculino</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Turno</label>
                            <select class="form-control" name="turno" required>
                                <option value="">Selecciona turno</option>
                                <option value="Matutino">Matutino</option>
                                <option value="Vespertino">Vespertino</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Correo institucional</label>
                            <input type="email" class="form-control" name="correo_inst" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Carrera</label>
                            <select class="form-select" name="carrera" required>
                                <option value="">Selecciona carrera</option>
                                <option value="ISC">ISC</option>
                                <option value="Electromecánica">Electromecánica</option>
                                <option value="Industrial">Industrial</option>
                                <option value="IGE">IGE</option>
                                <option value="Ambiental">Ambiental</option>
                                <option value="Contador">Contador</option>
                                <option value="Turismo">Turismo</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Generación</label>
                            <input type="text" class="form-control" name="generacion">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Actividad extraescolar</label>
                            <select class="form-select" name="actividad_extraescolar">
                                <option value="">Selecciona actividad</option>
                                <option value="1">Escolta</option>
                                <option value="2">Banderolas</option>
                                <option value="3">Danza folclórica</option>
                                <option value="4">Bailes latinos</option>
                                <option value="5">Rondalla</option>
                                <option value="6">Arcilla</option>
                                <option value="7">Basquetbol</option>
                                <option value="8">Futbol</option>
                                <option value="9">Atletismo</option>
                                <option value="10">Volibol</option>
                                <option value="11">Beisbol</option>
                                <option value="12">Lenguaje de Señas</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tipo de usuario</label>
                            <select class="form-control" name="id_tipo" required>
                                <option value="">Selecciona tipo</option>
                                <option value="1">Administrador</option>
                                <option value="2">Usuario</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
