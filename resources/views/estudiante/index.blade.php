<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal del Estudiante - ITSSMT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #6366f1; /* Fallback Indigo */
            --color-primary-light: rgba(99, 102, 241, 0.1);
            --color-secondary: #8b5cf6; /* Fallback Púrpura */
            --color-secondary-light: rgba(139, 92, 246, 0.1);
            --color-accent: #3b82f6; /* Fallback Azul vibrante */
            --color-accent-light: rgba(59, 130, 246, 0.1);
            --color-success: #10b981; /* Esmeralda */
            --color-success-light: rgba(16, 185, 129, 0.1);
            --color-navy: #1e1b4b; /* Deep Indigo Navy */
            --color-teal: #6366f1; /* Elemento de acento */
            --color-bg: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 20px 40px rgba(99, 102, 241, 0.05);
            --theme-shadow: rgba(99, 102, 241, 0.2);
            --bg-gradient-start: #f5f7ff;
            --bg-gradient-end: #e0e7ff;
        }

        /* Temas específicos para cada apartado */
        body.theme-perfil {
            --color-primary: #6366f1;
            --color-primary-light: rgba(99, 102, 241, 0.1);
            --color-secondary: #8b5cf6;
            --color-secondary-light: rgba(139, 92, 246, 0.1);
            --color-accent: #3b82f6; /* Azul Royal en lugar de Rosa */
            --color-teal: #6366f1;
            --theme-shadow: rgba(99, 102, 241, 0.25);
            --bg-gradient-start: #f5f7ff;
            --bg-gradient-end: #e0e7ff;
        }

        body.theme-inscripcion {
            --color-primary: #0d9488;
            --color-primary-light: rgba(13, 148, 136, 0.1);
            --color-secondary: #10b981;
            --color-secondary-light: rgba(16, 185, 129, 0.1);
            --color-accent: #f59e0b;
            --color-teal: #0d9488;
            --theme-shadow: rgba(13, 148, 136, 0.25);
            --bg-gradient-start: #f0fdfa;
            --bg-gradient-end: #ccfbf1;
        }

        body.theme-calificaciones {
            --color-primary: #d97706;
            --color-primary-light: rgba(217, 119, 6, 0.1);
            --color-secondary: #f97316;
            --color-secondary-light: rgba(249, 115, 22, 0.1);
            --color-accent: #6366f1;
            --color-teal: #d97706;
            --theme-shadow: rgba(217, 119, 6, 0.25);
            --bg-gradient-start: #fffbeb;
            --bg-gradient-end: #fef3c7;
        }

        body.theme-constancias {
            --color-primary: #0284c7;
            --color-primary-light: rgba(2, 132, 199, 0.1);
            --color-secondary: #06b6d4;
            --color-secondary-light: rgba(6, 182, 212, 0.1);
            --color-accent: #8b5cf6;
            --color-teal: #0284c7;
            --theme-shadow: rgba(2, 132, 199, 0.25);
            --bg-gradient-start: #f0f9ff;
            --bg-gradient-end: #e0f2fe;
        }

        body.theme-eventos {
            --color-primary: #7c3aed; /* Violeta en lugar de Rosa */
            --color-primary-light: rgba(124, 58, 237, 0.1);
            --color-secondary: #3b82f6; /* Azul en lugar de Púrpura */
            --color-secondary-light: rgba(59, 130, 246, 0.1);
            --color-accent: #10b981; /* Verde Esmeralda en lugar de Teal */
            --color-teal: #7c3aed;
            --theme-shadow: rgba(124, 58, 237, 0.25);
            --bg-gradient-start: #f5f3ff;
            --bg-gradient-end: #ede9fe;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, #eef2ff 50%, var(--bg-gradient-end) 100%);
            background-attachment: fixed;
            color: #1e293b;
            min-height: 100vh;
            margin: 0;
            font-size: 1rem;
            position: relative;
            overflow-x: hidden;
            transition: color 0.3s ease;
        }

        /* Ambient background blobs */
        .ambient-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.12;
            z-index: -1;
            pointer-events: none;
        }
        .ambient-blob-1 {
            width: 450px;
            height: 450px;
            background: var(--color-secondary);
            top: -100px;
            left: -100px;
            animation: float-blob-1 20s infinite alternate ease-in-out;
        }
        .ambient-blob-2 {
            width: 500px;
            height: 500px;
            background: var(--color-accent);
            bottom: -150px;
            right: -100px;
            animation: float-blob-2 25s infinite alternate ease-in-out;
        }
        .ambient-blob-3 {
            width: 350px;
            height: 350px;
            background: var(--color-primary);
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.06;
        }

        @keyframes float-blob-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(60px, 40px) scale(1.15); }
        }
        @keyframes float-blob-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-80px, -50px) scale(0.9); }
        }

        .navbar-custom {
            background: rgba(30, 27, 75, 0.85); /* Deep navy translúcido */
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 0.7rem 2rem;
            height: 75px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 24px;
            padding: 1.5rem;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            position: sticky;
            top: 100px;
            transition: all 0.3s ease;
        }

        .main-content-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 28px;
            padding: 2.5rem;
            min-height: calc(100vh - 160px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            transition: all 0.3s ease;
        }

        .profile-section-sidebar {
            text-align: center;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px dashed rgba(99, 102, 241, 0.15);
        }

        .profile-avatar-sidebar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--color-primary);
            margin-bottom: 1rem;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.2);
            transition: transform 0.3s ease;
        }
        .profile-avatar-sidebar:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .student-name-sidebar {
            font-weight: 800;
            color: var(--color-navy);
            font-size: 1.25rem;
            margin-bottom: 0.3rem;
        }

        .student-control-sidebar {
            font-size: 0.85rem;
            color: var(--color-primary);
            font-weight: 700;
            background: var(--color-primary-light);
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        .nav-pills-custom .nav-link {
            color: #475569;
            font-weight: 600;
            padding: 0.9rem 1.2rem;
            border-radius: 16px;
            margin-bottom: 0.6rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid transparent;
        }

        .nav-pills-custom .nav-link i {
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }

        .nav-pills-custom .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: var(--color-primary);
            border-color: rgba(99, 102, 241, 0.15);
            transform: translateX(6px);
        }

        .nav-pills-custom .nav-link:hover i {
            transform: scale(1.15) rotate(-5deg);
        }

        .nav-pills-custom .nav-link.active {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 50%, var(--color-accent) 100%);
            border-radius: 24px;
            padding: 3.5rem 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.18);
            margin-bottom: 2.5rem;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            animation: float-shape-1 10s infinite alternate ease-in-out;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: 20%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            animation: float-shape-2 8s infinite alternate ease-in-out;
        }

        @keyframes float-shape-1 {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-20px, 20px); }
        }
        @keyframes float-shape-2 {
            0% { transform: translate(0, 0); }
            100% { transform: translate(15px, -15px); }
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 2rem;
            border-bottom: 2px solid rgba(99, 102, 241, 0.15);
            padding-bottom: 1rem;
        }
        .section-header h4 { font-size: 1.6rem; font-weight: 800; color: var(--color-navy); margin: 0; }
        .section-header i {
            color: var(--color-primary);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .info-card-premium {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        .info-card-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(99, 102, 241, 0.08);
            border-color: rgba(139, 92, 246, 0.3);
            background: rgba(255, 255, 255, 0.6);
        }

        .info-card-premium i {
            font-size: 2rem;
            color: var(--color-primary);
            background: var(--color-primary-light);
            padding: 10px;
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        .info-card-premium:hover i {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
        }

        .custom-card-light {
            background: rgba(255, 255, 255, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: 1.75rem;
            transition: all 0.3s ease;
        }
        .custom-card-light:hover {
            border-color: rgba(99, 102, 241, 0.2);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.04);
            transform: translateY(-2px);
        }

        .actividad-label {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: block;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .actividad-label:hover { 
            border-color: rgba(139, 92, 246, 0.3); 
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.6);
        }
        .actividad-input:checked + .actividad-label {
            background: rgba(255, 255, 255, 0.85);
            border-color: var(--color-primary);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.12);
        }
        .actividad-input:checked + .actividad-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(to bottom, var(--color-primary), var(--color-secondary));
            border-radius: 20px 0 0 20px;
        }

        .logistica-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 8px;
            padding: 8px 14px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--color-success) 0%, #059669 100%);
            color: white;
            padding: 1.1rem;
            border-radius: 16px;
            font-weight: 800;
            font-size: 1.1rem;
            width: 100%;
            border: none;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.35);
        }
        .btn-submit:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.5);
            filter: brightness(1.05);
        }

        .btn-navy {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            border-radius: 16px;
            font-weight: 700;
            padding: 0.8rem 1.8rem;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        }
        .btn-navy:hover {
            background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-accent) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(139, 92, 246, 0.35);
        }

        .badge-signed {
            background: var(--color-success-light);
            color: var(--color-success);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 6px 12px;
            font-weight: 700;
            border-radius: 20px;
        }

        .badge-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
            padding: 6px 12px;
            font-weight: 700;
            border-radius: 20px;
        }

        /* Glass table style */
        .table-responsive {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .table thead {
            background: rgba(99, 102, 241, 0.08) !important;
            border-radius: 12px;
        }
        .table thead th {
            color: var(--color-navy);
            font-weight: 700;
            border: none;
        }
        .table tbody tr {
            transition: all 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.4) !important;
        }

        .dropdown-menu {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
        }
        .dropdown-item {
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: var(--color-primary-light);
            color: var(--color-primary);
        }

        .navbar-avatar {
            border: 3px solid var(--color-primary) !important;
            box-shadow: 0 0 15px var(--theme-shadow);
            transition: all 0.5s ease;
        }
    </style>
</head>
<body>

    <!-- Ambient background blobs -->
    <div class="ambient-blob ambient-blob-1"></div>
    <div class="ambient-blob ambient-blob-2"></div>
    <div class="ambient-blob ambient-blob-3"></div>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" height="50" alt="Logo">
            <span class="text-white fw-bold fs-5 d-none d-md-block">Portal Estudiantil ITSSMT</span>
        </div>

        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-3 text-white text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                @if($user->fotografia_perfil)
                    <img src="{{ Storage::url('perfiles/' . $user->fotografia_perfil) }}" class="rounded-circle navbar-avatar" width="45" height="45" style="object-fit: cover;">
                @else
                    <img src="{{ asset('assets/images/faces/face28.png') }}" class="rounded-circle navbar-avatar" width="45" height="45">
                @endif
                <span class="fw-bold d-none d-sm-block">{{ $user->nombre }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2 border-0 mt-3" style="border-radius: 15px;">
                <li><a class="dropdown-item py-2 fw-bold" href="{{ route('perfil.index') }}"><i class="mdi mdi-account-cog me-2 text-teal"></i> Mi Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger fw-bold bg-transparent border-0 w-100 text-start">
                            <i class="mdi mdi-logout me-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 100px; padding-bottom: 60px; max-width: 1400px;">
        
        @if(session('success'))
            <div class="alert alert-success p-3 rounded-4 mb-4 fw-bold shadow-sm border-0 d-flex align-items-center gap-2">
                <i class="mdi mdi-check-circle fs-4"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            
            <!-- Menu Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="sidebar-card">
                    <div class="profile-section-sidebar">
                        @if($user->fotografia_perfil)
                            <img src="{{ Storage::url('perfiles/' . $user->fotografia_perfil) }}" class="profile-avatar-sidebar">
                        @else
                            <img src="{{ asset('assets/images/faces/face28.png') }}" class="profile-avatar-sidebar">
                        @endif
                        <div class="student-name-sidebar">{{ $user->nombre }} {{ $user->apat }}</div>
                        <div class="student-control-sidebar">N° Ctrl: {{ $user->num_control }}</div>
                    </div>

                    <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-perfil-tab" data-bs-toggle="pill" data-bs-target="#v-pills-perfil" type="button" role="tab" aria-controls="v-pills-perfil" aria-selected="true">
                            <i class="mdi mdi-account"></i> Mi Perfil
                        </button>
                        <button class="nav-link" id="v-pills-inscripcion-tab" data-bs-toggle="pill" data-bs-target="#v-pills-inscripcion" type="button" role="tab" aria-controls="v-pills-inscripcion" aria-selected="false">
                            <i class="mdi mdi-pencil-box-outline"></i> Inscripción
                        </button>
                        <button class="nav-link" id="v-pills-calificaciones-tab" data-bs-toggle="pill" data-bs-target="#v-pills-calificaciones" type="button" role="tab" aria-controls="v-pills-calificaciones" aria-selected="false">
                            <i class="mdi mdi-star-outline"></i> Calificaciones
                        </button>
                        <button class="nav-link" id="v-pills-constancias-tab" data-bs-toggle="pill" data-bs-target="#v-pills-constancias" type="button" role="tab" aria-controls="v-pills-constancias" aria-selected="false">
                            <i class="mdi mdi-certificate"></i> Constancias
                        </button>
                        <button class="nav-link" id="v-pills-eventos-tab" data-bs-toggle="pill" data-bs-target="#v-pills-eventos" type="button" role="tab" aria-controls="v-pills-eventos" aria-selected="false">
                            <i class="mdi mdi-calendar-star"></i> Eventos Especiales
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9 col-md-8">
                <!-- Encabezado de la Sección -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4 border-bottom border-light pb-2">
                    <h4 class="fw-bold text-dark mb-0">Sistema de Actividades Extraescolares</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/') }}" class="btn text-white fw-bold d-flex align-items-center px-3 rounded-pill" style="background: linear-gradient(135deg, var(--color-teal) 0%, var(--color-navy) 100%); border: none; box-shadow: 0 4px 10px rgba(56, 97, 115, 0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="mdi mdi-home me-2 fs-5"></i> Inicio
                        </a>
                    </div>
                </div>

                <div class="main-content-card">
                    <div class="tab-content" id="v-pills-tabContent">
                        
                        <!-- TAB: PERFIL -->
                        <div class="tab-pane fade show active" id="v-pills-perfil" role="tabpanel" aria-labelledby="v-pills-perfil-tab">
                            <div class="welcome-banner">
                                <h1 class="fw-bold fs-1 mb-2">¡Hola, {{ $user->nombre }}!</h1>
                                <p class="fs-4 opacity-90 mb-0">Bienvenido a tu Portal de Actividades Extraescolares ITSSMT</p>
                            </div>

                            <div class="section-header">
                                <i class="mdi mdi-account-circle fs-2 text-teal"></i>
                                <h4>Mi Información General</h4>
                            </div>

                            <div class="info-grid">
                                <div class="info-card-premium">
                                    <i class="mdi mdi-identifier"></i>
                                    <div>
                                        <div class="small text-muted fw-bold text-uppercase">Matrícula</div>
                                        <div class="fw-bold fs-5">{{ $user->num_control }}</div>
                                    </div>
                                </div>
                                <div class="info-card-premium">
                                    <i class="mdi mdi-school"></i>
                                    <div>
                                        <div class="small text-muted fw-bold text-uppercase">Carrera</div>
                                        <div class="fw-bold fs-5 text-teal">{{ $user->carrera ?? 'Sin Carrera' }}</div>
                                    </div>
                                </div>
                                <div class="info-card-premium">
                                    <i class="mdi mdi-clock-outline"></i>
                                    <div>
                                        <div class="small text-muted fw-bold text-uppercase">Turno</div>
                                        <div class="fw-bold fs-5">{{ $user->turno ?? 'Sin asignar' }}</div>
                                    </div>
                                </div>
                                <div class="info-card-premium">
                                    <i class="mdi mdi-email-outline"></i>
                                    <div>
                                        <div class="small text-muted fw-bold text-uppercase">Correo Inst.</div>
                                        <div class="fw-bold text-muted small">{{ $user->correo_inst }}</div>
                                    </div>
                                </div>
                            </div>

                            @if($user->actividad)
                                <div class="section-header mt-5">
                                    <i class="mdi mdi-run-fast fs-2 text-teal"></i>
                                    <h4>Actividad Complementaria Activa</h4>
                                </div>
                                <div class="custom-card-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <h3 class="fw-bold text-navy mb-2">{{ $user->actividad->nombre }}</h3>
                                            <p class="text-muted mb-0"><i class="mdi mdi-account-tie me-1"></i> Docente: <b>{{ $user->actividad->docente->nombre ?? 'Por Asignar' }} {{ $user->actividad->docente->apet ?? '' }}</b></p>
                                        </div>
                                        <div class="col-md-5 mt-3 mt-md-0 border-start border-light ps-md-4">
                                            <div class="logistica-item">
                                                <i class="mdi mdi-map-marker text-teal"></i>
                                                <span class="small fw-bold">Área: {{ $user->actividad->lugar ?? 'Por definir' }}</span>
                                            </div>
                                            <div class="logistica-item mt-2">
                                                <i class="mdi mdi-clock-outline text-teal"></i>
                                                <span class="small fw-bold">Horario: {{ $user->actividad->horario }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- TAB: INSCRIPCION -->
                        <div class="tab-pane fade" id="v-pills-inscripcion" role="tabpanel" aria-labelledby="v-pills-inscripcion-tab">
                            <div class="section-header">
                                <i class="mdi mdi-pencil-box-outline fs-2 text-teal"></i>
                                <h4>Inscripción o Reinscripción</h4>
                            </div>

                            @if($aprobadas >= 2)
                                <div class="text-center py-5">
                                    <i class="mdi mdi-check-decagram text-success" style="font-size: 6rem;"></i>
                                    <h3 class="fw-bold text-success mt-4">¡Créditos Completados!</h3>
                                    <p class="text-muted">Has completado con éxito todas tus actividades extraescolares requeridas.</p>
                                </div>
                            @elseif($user->actividad)
                                <div class="text-center py-5 bg-light rounded-4 border border-success border-opacity-25">
                                    <i class="mdi mdi-check-circle text-success" style="font-size: 5rem;"></i>
                                    <h3 class="fw-bold text-success mt-4">Inscripción Activa</h3>
                                    <p class="fs-5 mt-2 text-muted">Ya has sido registrado en la actividad: <br><strong class="text-navy fs-4">{{ $user->actividad->nombre }}</strong>.</p>
                                </div>
                            @else
                                <form action="{{ route('estudiante.inscribir') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="fw-bold text-navy mb-2 fs-5">1. VERIFICA O ACTUALIZA TU CARRERA</label>
                                        <select class="form-select border-2 border-light rounded-3 fw-bold p-3" name="carrera" required>
                                            @foreach(['Sistemas', 'Electromecánica', 'Industrial', 'Gestión', 'Ambiental', 'Contador', 'Turismo'] as $c)
                                                <option value="{{ $c }}" {{ str_contains($user->carrera, $c) ? 'selected' : '' }}>{{ $c }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="fw-bold text-navy mb-3 fs-5">2. SELECCIONA TU ACTIVIDAD SABATINA</label>
                                        @if(isset($actividades) && $actividades->count() > 0)
                                            <div class="row g-3">
                                                @foreach($actividades as $act)
                                                    <div class="col-12">
                                                        <input type="radio" name="id_actividad" id="act_{{ $act->id_act }}" value="{{ $act->id_act }}" class="d-none actividad-input" required {{ $user->actividad_extraescolar == $act->id_act ? 'checked' : '' }}>
                                                        <label for="act_{{ $act->id_act }}" class="actividad-label">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-7">
                                                                    <div class="fw-bold fs-4 text-navy">{{ $act->nombre }}</div>
                                                                    <div class="text-teal fw-semibold mt-1"><i class="mdi mdi-account-tie"></i> Prof: {{ $act->docente->nombre ?? 'Por asignar' }}</div>
                                                                </div>
                                                                <div class="col-md-5 mt-2 mt-md-0 border-start border-light ps-md-3">
                                                                    <div class="logistica-item bg-white">
                                                                        <i class="mdi mdi-clock-outline text-teal"></i>
                                                                        <span class="small fw-bold">{{ $act->horario ?? 'Pendiente' }}</span>
                                                                    </div>
                                                                    <div class="logistica-item bg-white mt-1">
                                                                        <i class="mdi mdi-map-marker text-teal"></i>
                                                                        <span class="small fw-bold">{{ $act->lugar ?? 'Por definir' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="submit" class="btn-submit">
                                                Confirmar Inscripción <i class="mdi mdi-check-decagram ms-2"></i>
                                            </button>
                                        @else
                                            <div class="text-center py-5 bg-light rounded-4">
                                                <i class="mdi mdi-calendar-alert fs-1 text-muted"></i>
                                                <p class="fs-5 mt-2 fw-bold text-muted">No hay inscripciones abiertas en este momento.</p>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            @endif
                        </div>

                        <!-- TAB: CALIFICACIONES -->
                        <div class="tab-pane fade" id="v-pills-calificaciones" role="tabpanel" aria-labelledby="v-pills-calificaciones-tab">
                            <div class="section-header">
                                <i class="mdi mdi-star-outline fs-2 text-teal"></i>
                                <h4>Historial de Calificaciones y Conformidad</h4>
                            </div>

                            @if($historial->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-borderless">
                                        <thead class="table-light rounded-4">
                                            <tr>
                                                <th class="py-3 px-3">Actividad</th>
                                                <th class="py-3 text-center">Periodo</th>
                                                <th class="py-3 text-center">Parcial 1</th>
                                                <th class="py-3 text-center">Parcial 2</th>
                                                <th class="py-3 text-center">Parcial 3</th>
                                                <th class="py-3 text-center">Final</th>
                                                <th class="py-3 text-center">Conformidad / Firma</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($historial as $reg)
                                                @php
                                                    $p1 = $reg->parciales->where('num_parcial', 1)->first();
                                                    $p2 = $reg->parciales->where('num_parcial', 2)->first();
                                                    $p3 = $reg->parciales->where('num_parcial', 3)->first();
                                                @endphp
                                                <tr class="border-bottom">
                                                    <td class="px-3 fw-bold text-navy">{{ $reg->actividadExtraescolar->nombre ?? 'Actividad' }}</td>
                                                    <td class="text-center">Periodo {{ $reg->numero_periodo }}</td>
                                                    <td class="text-center fw-bold">{{ $p1 ? round($p1->calificacion) : '-' }}</td>
                                                    <td class="text-center fw-bold">{{ $p2 ? round($p2->calificacion) : '-' }}</td>
                                                    <td class="text-center fw-bold">{{ $p3 ? round($p3->calificacion) : '-' }}</td>
                                                    <td class="text-center fw-bold fs-5 text-teal">{{ $reg->calificacion_final !== null ? round($reg->calificacion_final) : 'Cursando' }}</td>
                                                    <td class="text-center">
                                                        @if($reg->calificacion_final !== null)
                                                            @if($reg->firma_estudiante)
                                                                <span class="badge badge-signed px-3 py-2 rounded-pill"><i class="mdi mdi-check-decagram"></i> Firmado de Conformidad</span>
                                                            @else
                                                                <form action="{{ route('estudiante.firmar', $reg->id_historial) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-outline-success btn-sm fw-bold rounded-pill px-3" onclick="return confirm('¿Aceptas que tu calificación es correcta? Una vez firmado no podrás cambiarlo.');">
                                                                        <i class="mdi mdi-pen"></i> Firmar
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-pending px-3 py-2 rounded-pill"><i class="mdi mdi-progress-clock"></i> En curso</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5 bg-light rounded-4">
                                    <i class="mdi mdi-history fs-1 text-muted opacity-30"></i>
                                    <p class="fs-5 mt-2 fw-bold text-muted">Aún no tienes registros de calificaciones.</p>
                                </div>
                            @endif
                        </div>

                        <!-- TAB: CONSTANCIAS -->
                        <div class="tab-pane fade" id="v-pills-constancias" role="tabpanel" aria-labelledby="v-pills-constancias-tab">
                            <div class="section-header">
                                <i class="mdi mdi-certificate fs-2 text-teal"></i>
                                <h4>Constancia de Liberación</h4>
                            </div>

                            @if($aprobadas >= 2)
                                <div class="card border-0 bg-success bg-opacity-5 p-5 text-center rounded-4 border border-success border-opacity-10 shadow-sm">
                                    <i class="mdi mdi-certificate text-success" style="font-size: 6rem;"></i>
                                    <h2 class="fw-bold text-success mt-4">¡Créditos Completados!</h2>
                                    <p class="text-muted fs-5">Has cubierto y aprobado los dos periodos extraescolares requeridos.</p>
                                    <div class="mt-4">
                                        @if($user->impresiones_constancia >= 2)
                                            <div class="alert alert-danger fw-bold fs-5 rounded-4 border-0">
                                                <i class="mdi mdi-lock-outline me-2"></i> Límite de descargas alcanzado. Ya has emitido tu constancia 2 veces.
                                            </div>
                                        @else
                                            <a href="{{ route('constancias.pdf', $user->num_control) }}" target="_blank" class="btn btn-navy px-5 py-3 rounded-4 fw-bold">
                                                <i class="mdi mdi-download me-2"></i> Descargar Constancia Final
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="custom-card-light">
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <i class="mdi mdi-progress-check fs-1 text-teal"></i>
                                        <div>
                                            <h4 class="fw-bold text-navy mb-1">Tu Progreso de Liberación</h4>
                                            <p class="text-muted mb-0">Requieres aprobar un total de 2 períodos.</p>
                                        </div>
                                    </div>
                                    <div class="progress rounded-pill mb-3" style="height: 20px;">
                                        <div class="progress-bar bg-teal rounded-pill" role="progressbar" style="width: {{ ($aprobadas / 2) * 100 }}%" aria-valuenow="{{ $aprobadas }}" aria-valuemin="0" aria-valuemax="2">
                                            {{ $aprobadas }} / 2 Aprobados
                                        </div>
                                    </div>
                                    <p class="fw-semibold text-muted"><i class="mdi mdi-alert-circle-outline"></i> Te falta aprobar <b>{{ 2 - $aprobadas }} periodo(s)</b> para poder descargar tu constancia final.</p>
                                </div>
                            @endif
                        </div>

                        <!-- TAB: EVENTOS -->
                        <div class="tab-pane fade" id="v-pills-eventos" role="tabpanel" aria-labelledby="v-pills-eventos-tab">
                            <div class="section-header">
                                <i class="mdi mdi-calendar-star fs-2 text-teal"></i>
                                <h4>Eventos Especiales e Institucionales</h4>
                            </div>

                            @if(isset($eventos) && $eventos->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-borderless">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="py-3 px-3">Evento</th>
                                                <th class="py-3">Área / Lugar</th>
                                                <th class="py-3 text-center">Horario / Fechas</th>
                                                <th class="py-3 text-center">Calificación</th>
                                                <th class="py-3">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eventos as $ev)
                                                <tr class="border-bottom">
                                                    <td class="px-3">
                                                        <div class="fw-bold text-navy">{{ $ev->nombre }}</div>
                                                        <small class="text-muted d-block">{{ $ev->descripcion }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border px-2 py-1"><i class="mdi mdi-map-marker text-teal"></i> {{ $ev->area->nombre ?? 'Por definir' }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <small class="fw-bold">{{ $ev->horario ?? 'S/H' }}</small>
                                                    </td>
                                                    <td class="text-center fw-bold text-teal">
                                                        {{ $ev->pivot->calificacion ?? 'En espera' }}
                                                    </td>
                                                    <td class="text-muted small">
                                                        {{ $ev->pivot->obs ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5 bg-light rounded-4">
                                    <i class="mdi mdi-calendar-blank fs-1 text-muted opacity-30"></i>
                                    <p class="fs-5 mt-2 fw-bold text-muted">Aún no has sido agregado a ningún evento especial.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('#v-pills-tab button[data-bs-toggle="pill"]');
            
            function updateTheme(tabId) {
                document.body.classList.remove('theme-perfil', 'theme-inscripcion', 'theme-calificaciones', 'theme-constancias', 'theme-eventos');
                
                if (tabId.includes('perfil')) {
                    document.body.classList.add('theme-perfil');
                } else if (tabId.includes('inscripcion')) {
                    document.body.classList.add('theme-inscripcion');
                } else if (tabId.includes('calificaciones')) {
                    document.body.classList.add('theme-calificaciones');
                } else if (tabId.includes('constancias')) {
                    document.body.classList.add('theme-constancias');
                } else if (tabId.includes('eventos')) {
                    document.body.classList.add('theme-eventos');
                }
            }

            const activeTab = document.querySelector('#v-pills-tab button.active');
            if (activeTab) {
                updateTheme(activeTab.id);
            }

            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(event) {
                    updateTheme(event.target.id);
                });
            });
        });
    </script>

    {{-- Chatbot Asistente Virtual --}}
    @include('cpanel.partials.chatbot')
</body>
</html>
