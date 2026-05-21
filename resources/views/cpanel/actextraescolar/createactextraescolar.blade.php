@extends('cpanel.plantilla')

@section('title','Nueva Actividad Extraescolar')

@section('content')

    <div class="container mt-4">

        <div class="card shadow-lg border-0">
            <div class="card-body">

                <h4 class="card-title mb-4"><i class="mdi mdi-plus-circle"></i> Agregar Nueva Actividad</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('actextraescolar.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre de la Actividad *</label>
                            <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Ej. Futbol Femenil" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Docente Asignado</label>
                            <select class="form-select" name="no_empleado">
                                <option value="">-- Sin asignar (Por definir) --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->no_empleado }}" {{ old('no_empleado') == $docente->no_empleado ? 'selected' : '' }}>
                                        {{ $docente->nombre }} {{ $docente->apet }} {{ $docente->amat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Horario *</label>
                            <input type="text" class="form-control" name="horario" value="{{ old('horario') }}" placeholder="Ej. Lunes y Miércoles 14:00 - 16:00">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Cupo Hombres *</label>
                            <input type="number" class="form-control" name="cupo_masculino" value="{{ old('cupo_masculino', 15) }}" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Cupo Mujeres *</label>
                            <input type="number" class="form-control" name="cupo_femenino" value="{{ old('cupo_femenino', 15) }}" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Área / Lugar *</label>
                            <input type="text" class="form-control" name="lugar" value="{{ old('lugar') }}" placeholder="Ej. Cancha de Usos Múltiples">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Materiales Requeridos</label>
                            <textarea class="form-control" name="materiales" rows="3" placeholder="Ej. Balón, ropa deportiva...">{{ old('materiales') }}</textarea>
                        </div>
                    </div>

                    <div class="text-end mt-3 border-top pt-3">
                        <a href="{{ route('actextraescolar.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Guardar Actividad</button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
