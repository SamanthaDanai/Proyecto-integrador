@extends('cpanel.plantilla')

@section('title', 'Mi Perfil')
@section('page_title', 'PERFIL')

@push('styles')
<style>
    body {
        background-color: #f1f5f9 !important;
        color: #1e293b !important;
        font-size: 1.1rem !important;
    }

    .profile-banner {
        background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-teal) 100%);
        height: 200px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        padding-left: 3rem;
        margin-bottom: -100px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .main-container {
        padding-top: 2rem;
        position: relative;
        z-index: 2;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 3rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: none;
    }

    .avatar-large {
        width: 180px;
        height: 180px;
        border-radius: 40px;
        object-fit: cover;
        border: 6px solid #ffffff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        background: #f1f5f9;
    }

    .edit-photo-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: var(--color-green);
        color: var(--color-navy);
        width: 45px;
        height: 45px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 4px solid #ffffff;
        transition: all 0.3s ease;
    }
    .edit-photo-btn:hover { transform: scale(1.1); background: #fff; }

    .custom-label {
        font-size: 1rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 0.8rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .custom-input {
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 18px;
        padding: 1.1rem 1.4rem;
        color: var(--color-navy);
        font-weight: 600;
        font-size: 1.2rem; /* Input grande */
        width: 100%;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        background: #ffffff;
        border-color: var(--color-teal);
        box-shadow: 0 0 0 5px rgba(56, 97, 115, 0.1);
        outline: none;
    }
    .custom-input[readonly] { background: #f1f5f9; color: #94a3b8; cursor: not-allowed; }

    .section-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--color-navy);
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .section-title i { color: var(--color-teal); font-size: 2.2rem; }

    .btn-save-lg {
        background: var(--color-green);
        color: var(--color-navy);
        padding: 1.2rem 3rem;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.2rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }
    .btn-save-lg:hover { filter: brightness(1.05); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    
    <div class="profile-banner">
        <h1 class="text-white fw-bold mb-0" style="font-size: 2.5rem;">Configuración de mi Cuenta</h1>
    </div>

    <div class="container main-container">
        <div class="row g-5">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="profile-card text-center">
                    <form action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data" id="form-foto">
                        @csrf
                        <div class="position-relative d-inline-block mb-4">
                            @if(Auth::user()->fotografia_perfil)
                                <img src="{{ Storage::url('perfiles/' . Auth::user()->fotografia_perfil) }}" class="avatar-large">
                            @else
                                <img src="{{ asset('assets/images/faces/face28.png') }}" class="avatar-large">
                            @endif
                            <label for="input-foto" class="edit-photo-btn shadow">
                                <i class="mdi mdi-camera fs-4"></i>
                            </label>
                            <input type="file" id="input-foto" name="fotografia" hidden onchange="document.getElementById('form-foto').submit()">
                        </div>
                    </form>

                    <h2 class="fw-bold mb-2" style="color: var(--color-navy);">{{ Auth::user()->nombre }}</h2>
                    <p class="fs-5 text-teal fw-bold mb-4">{{ Auth::user()->tipo->descripcion }}</p>
                    
                    <div class="text-start p-4 bg-light rounded-4">
                        <div class="mb-3"><i class="mdi mdi-identifier text-teal me-2"></i> <b>N° Control:</b> <span class="fs-5">{{ Auth::user()->num_control }}</span></div>
                        <div><i class="mdi mdi-email text-teal me-2"></i> <b>Correo:</b> <div class="text-truncate small">{{ Auth::user()->correo_inst }}</div></div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-8">
                <div class="profile-card">
                    @if(session('success'))
                        <div class="alert alert-success p-3 rounded-4 mb-5 fw-bold">
                            <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('perfil.datos') }}" method="POST">
                        @csrf
                        
                        <h4 class="section-title"><i class="mdi mdi-account-details-outline"></i> Información Personal</h4>
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="custom-label">Nombre y Apellidos</label>
                                <input type="text" class="custom-input" name="nombre" value="{{ Auth::user()->nombre }}" required {{ Auth::user()->id_tipo == 2 ? 'readonly' : '' }}>
                            </div>

                            @if(Auth::user()->id_tipo == 4)
                            <div class="col-md-6">
                                <label class="custom-label">Teléfono de Contacto</label>
                                <input type="text" class="custom-input" name="telefono" value="{{ Auth::user()->docente->telefono ?? '' }}" placeholder="Ej. 248 123 4567">
                            </div>
                            <div class="col-md-6">
                                <label class="custom-label">Área Académica</label>
                                <input type="text" class="custom-input" name="area" value="{{ Auth::user()->docente->area ?? '' }}" placeholder="Ej. Sistemas">
                            </div>
                            @endif
                        </div>

                        @if(Auth::user()->id_tipo != 2)
                        <h4 class="section-title mt-5"><i class="mdi mdi-shield-key-outline"></i> Seguridad</h4>
                        
                        <div class="mb-5">
                            <label class="custom-label">Cambiar Contraseña</label>
                            <input type="password" class="custom-input" name="nueva_contrasena" placeholder="Escribe aquí tu nueva clave">
                            <div class="form-text text-muted mt-2 fs-6">Deja el campo vacío si no deseas cambiar tu contraseña actual.</div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn-save-lg shadow">
                                <i class="mdi mdi-content-save-check"></i> Guardar Todos los Cambios
                            </button>
                        </div>
                        @else
                        <div class="mt-5 p-4 bg-light rounded-4 border-start border-4 border-teal text-muted">
                            <i class="mdi mdi-information me-2 fs-5"></i> Los datos de acceso de los estudiantes son administrados centralmente por la institución.
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
