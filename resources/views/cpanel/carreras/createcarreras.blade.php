@extends('cpanel.plantilla')

@section('title', 'Agregar Carrera')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
                    <h5 class="mb-0"><i class="mdi mdi-plus-circle me-2"></i>Agregar Nueva Carrera</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('carreras.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-semibold">Nombre de la Carrera</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Ingeniería en Sistemas..." required>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('carreras.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Regresar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> Guardar Carrera
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
