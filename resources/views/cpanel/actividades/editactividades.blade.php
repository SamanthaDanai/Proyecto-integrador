@extends('cpanel.plantilla')

@section('title', 'Editar Grupo')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h4 class="card-title fw-bold text-dark mb-0"><i class="mdi mdi-pencil-outline me-2 text-primary"></i> Editar Evento #{{ $actividade->id_actividad }}</h4>
        </div>
        
        <div class="card-body p-4">
            
            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('actividades.update', $actividade->id_actividad) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Nombre del Evento *</label>
                        <input type="text" class="form-control rounded-3" name="nombre" value="{{ old('nombre', $actividade->nombre) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Docente Responsable</label>
                        <select class="form-select rounded-3" name="no_empleado">
                            <option value="">-- Sin asignar (Por definir) --</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->no_empleado }}" 
                                    {{ old('no_empleado', $docenteActual ? $docenteActual->no_empleado : '') == $docente->no_empleado ? 'selected' : '' }}>
                                    {{ $docente->nombre }} {{ $docente->apet }} {{ $docente->amat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Horario *</label>
                        <input type="text" class="form-control rounded-3" name="horario" value="{{ old('horario', $actividade->horario) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Lugar / Área *</label>
                        <select class="form-select rounded-3" name="id_area" required>
                            <option value="">-- Seleccione el Área --</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id_area }}" {{ old('id_area', $actividade->id_area) == $area->id_area ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary">Descripción (Opcional)</label>
                        <textarea class="form-control rounded-3" name="descripcion" rows="3">{{ old('descripcion', $actividade->descripcion) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end border-top pt-3">
                    <a href="{{ route('actividades.index') }}" class="btn btn-light rounded-pill px-4 me-2 border">Cancelar</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="mdi mdi-content-save me-1"></i> Actualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
