@extends('cpanel.plantilla')

@section('title', 'Editar Administrador')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 25px;">
                <div class="card-body p-5">
                    <h2 class="fw-800 text-navy mb-4"><i class="mdi mdi-account-edit text-teal me-2"></i> Editar Administrador</h2>
                    
                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('administradores.update', $admin->num_control) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Número de Personal / Control</label>
                                <input type="text" name="num_control" class="form-control fw-bold" value="{{ $admin->num_control }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control fw-bold" value="{{ $admin->nombre }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" name="apat" class="form-control fw-bold" value="{{ $admin->apat }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" name="amat" class="form-control fw-bold" value="{{ $admin->amat }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="correo_inst" class="form-control fw-bold" value="{{ $admin->correo_inst }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Contraseña (opcional)</label>
                                <input type="password" name="contrasena" class="form-control fw-bold" placeholder="Dejar vacío para no cambiar">
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-3">
                            <button type="submit" class="btn btn-navy px-5 py-3 rounded-4 fw-bold shadow-sm flex-grow-1">
                                Actualizar Administrador <i class="mdi mdi-check-circle ms-1"></i>
                            </button>
                            <a href="{{ route('administradores.index') }}" class="btn btn-light px-4 py-3 rounded-4 fw-bold">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
