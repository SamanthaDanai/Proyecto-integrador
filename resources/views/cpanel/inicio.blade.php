@extends('cpanel.plantilla')

@section('title', 'Inicio')

@push('styles')
<style>
    .welcome-banner {
        background: #ffffff;
        border-radius: 15px;
        padding: 4rem 2rem;
        color: #1a1a2e;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: -80px;
        width: 300px;
        height: 300px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 50%;
    }

    .welcome-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 1rem;
        letter-spacing: 0.5px;
        color: #16213e;
    }

    .welcome-subtitle {
        font-size: 1.2rem;
        font-weight: 500;
        color: #6c757d;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .logo-img {
        max-height: 120px;
        margin-bottom: 1.5rem;
        mix-blend-mode: multiply; /* Magia para borrar cualquier residuo blanco si el banner es ligermente gris */
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4">
    <div class="row w-100 mx-0">
        <div class="col-12 px-0">
            <div class="welcome-banner">
                <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" class="logo-img" alt="Logo ITSSMT">
                <h1 class="welcome-title">Bienvenido al Sistema Web de Actividades Extraescolares</h1>
                <p class="welcome-subtitle">
                    del Instituto Tecnológico Superior de San Martín Texmelucan
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
