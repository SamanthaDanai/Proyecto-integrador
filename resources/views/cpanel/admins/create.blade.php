@extends('cpanel.plantilla')

@section('title', 'Nuevo Administrador')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 25px;">
                <div class="card-body p-5">
                    <h2 class="fw-800 text-navy mb-4"><i class="mdi mdi-account-plus text-teal me-2"></i> Registrar Administrador</h2>
                    
                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('administradores.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Número de Personal / Control</label>
                                <input type="text" name="num_control" class="form-control fw-bold" required placeholder="Ej. ADM001">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control fw-bold" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" name="apat" class="form-control fw-bold" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" name="amat" class="form-control fw-bold">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="correo_inst" class="form-control fw-bold" required placeholder="ejemplo@correo.com">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="contrasena" class="form-control fw-bold" required minlength="6">
                                <div class="form-text mt-2">Mínimo 6 caracteres para mayor seguridad.</div>
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-3">
                            <button type="submit" class="btn btn-navy px-5 py-3 rounded-4 fw-bold shadow-sm flex-grow-1">
                                Guardar Administrador <i class="mdi mdi-check-circle ms-1"></i>
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
