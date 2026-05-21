<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Portal Docente') - ITSSMT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-teal: #386173;
            --color-green: #B8D67A;
            --color-navy: #1F364A;
            --color-bg: #f1f5f9;
            --color-text: #1e293b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
            margin: 0;
            font-size: 1.05rem;
        }

        /* Sidebar Moderno */
        .sidebar {
            width: 280px;
            background: var(--color-navy);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 2rem 1.5rem;
            color: white;
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 3rem;
            text-decoration: none;
            color: white;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 0.8rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 1.2rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: var(--color-green);
        }

        .nav-link i {
            font-size: 1.4rem;
        }

        /* Content Area */
        .main-wrapper {
            margin-left: 280px;
            padding: 2rem 3rem;
            min-height: 100vh;
        }

        .top-nav {
            background: white;
            border-radius: 20px;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .card-custom {
            background: white;
            border-radius: 25px;
            padding: 2.5rem;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            margin-bottom: 2rem;
        }

        .text-navy {
            color: var(--color-navy) !important;
        }
        
        .bg-navy {
            background-color: var(--color-navy) !important;
            color: white;
        }
        
        .text-teal {
            color: var(--color-teal) !important;
        }

        .btn-green {
            background: var(--color-green);
            color: var(--color-navy);
            border-radius: 12px;
            font-weight: 700;
            padding: 0.8rem 1.5rem;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-green:hover { transform: translateY(-2px); filter: brightness(1.05); }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; padding: 1.5rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <a href="{{ route('docente.index') }}" class="sidebar-brand">
            <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" height="45" alt="Logo">
            <span class="fw-bold fs-5">Portal Docente</span>
        </a>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('docente.dashboard') }}" class="nav-link {{ request()->routeIs('docente.dashboard') ? 'active' : '' }}">
                    <i class="mdi mdi-view-dashboard-outline"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('docente.eventos') }}" class="nav-link {{ request()->routeIs('docente.eventos') ? 'active' : '' }}">
                    <i class="mdi mdi-calendar-star"></i> Eventos Inst.
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('docente.horarios') }}" class="nav-link {{ request()->routeIs('docente.horarios') ? 'active' : '' }}">
                    <i class="mdi mdi-clock-outline"></i> Mis Horarios
                </a>
            </li>
            <li class="nav-item mt-4">
                <hr class="opacity-10">
            </li>
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="mdi mdi-home"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('perfil.index') }}" class="nav-link {{ request()->routeIs('perfil.index') ? 'active' : '' }}">
                    <i class="mdi mdi-account-circle-outline"></i> Mi Perfil
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-wrapper">
        <header class="top-nav">
            <div class="fw-bold text-muted">
                Bienvenido, <span class="text-navy">{{ Auth::user()->nombre }}</span>
            </div>
            
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                    @if(Auth::user()->fotografia_perfil)
                        <img src="{{ Storage::url('perfiles/' . Auth::user()->fotografia_perfil) }}" class="rounded-circle border" width="40" height="40" style="object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/images/faces/face28.png') }}" class="rounded-circle border" width="40" height="40">
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-2">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold"><i class="mdi mdi-logout me-2"></i> Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    {{-- Chatbot Asistente Virtual --}}
    @include('cpanel.partials.chatbot')
</body>
</html>
