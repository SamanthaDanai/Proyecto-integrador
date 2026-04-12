@extends('cpanel.plantilla')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: white;">
            <div class="card-body text-center p-4">
                <h5 class="fw-bold mb-4" style="color: var(--color-navy);">Fotografía de Perfil</h5>
                
                <div class="mb-3">
                    @if(Auth::user()->fotografia_perfil)
                        <img src="{{ Storage::url('perfiles/' . Auth::user()->fotografia_perfil) }}" alt="Foto de perfil" class="rounded-circle object-fit-cover shadow-sm" style="width: 150px; height: 150px; border: 4px solid var(--color-green);">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 150px; height: 150px; background: #e2e8f0; border: 4px solid var(--color-green);">
                            <i class="mdi mdi-account text-secondary" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </div>

                <form action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold text-muted">Cambiar Fotografía</label>
                        <input class="form-control form-control-sm" type="file" name="fotografia" accept=".jpg,.jpeg,.png,.webp" required>
                    </div>
                    <button type="submit" class="btn w-100 fw-bold text-white shadow-sm" style="background-color: var(--color-teal); border-radius: 8px;">
                        <i class="mdi mdi-upload me-2"></i> Subir y Actualizar
                    </button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: white;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color: var(--color-navy);">Datos Personales</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert" style="border-radius: 8px;">
                        <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close pb-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('perfil.datos') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-bold small">Número de Control</label>
                            <input type="text" class="form-control border-0 bg-light" value="{{ Auth::user()->num_control }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted fw-bold small">Correo Institucional</label>
                            <input type="text" class="form-control border-0 bg-light" value="{{ Auth::user()->correo_inst }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted fw-bold small">Nombre(s) y Apellidos</label>
                            <input type="text" class="form-control" name="nombre" value="{{ Auth::user()->nombre }}" required>
                        </div>
                    </div>
                    
                    <hr class="my-4" style="border-color: #e2e8f0;">

                    <h6 class="fw-bold mb-3" style="color: var(--color-teal);">Seguridad: Cambiar Contraseña</h6>
                    <p class="text-muted small mb-3">Dejar en blanco si deseas mantener tu contraseña actual.</p>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold small">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="nueva_contrasena" placeholder="Escribe aquí tu nueva contraseña" pattern="^[a-zA-Z]{8}[0-9]{1}[\W_]{1}$" title="Debe tener 8 letras, 1 número y 1 carácter especial (ej. Password1!)">
                        <div class="form-text text-danger" style="font-size: 0.8rem;"><i class="mdi mdi-information-outline"></i> Formato Obligatorio: 8 Letras, 1 Número, 1 Símbolo Especial.</div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn fw-bold text-dark px-4 shadow-sm border-0" style="background-color: var(--color-green); border-radius: 8px;">
                            <i class="mdi mdi-content-save me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
