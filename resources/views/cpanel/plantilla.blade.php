<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Actividades Extraescolares - ITSSMT</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        :root {
            --color-teal: #386173;
            --color-green: #B8D67A;
            --color-navy: #1F364A;
            --color-white: #FFFFFF;
        }
        
        body { background-color: #f4f5f7; font-family: 'Outfit', sans-serif; }
        
        /* Navbar Superior (#1F364A a #386173) */
        .navbar-custom { background: linear-gradient(90deg, var(--color-navy) 0%, var(--color-teal) 100%); border-bottom: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .institute-name { color: var(--color-white); font-size: 1.15rem; letter-spacing: 0.5px; }
        
        /* Sidebar Vertical Premium */
        .sidebar { background: linear-gradient(180deg, var(--color-teal) 0%, var(--color-navy) 100%); border-right: none; min-height: calc(100vh - 60px); z-index: 100; box-shadow: 4px 0 25px rgba(0,0,0,0.05);}
        .sidebar .nav-link { color: var(--color-white); font-weight: 500; font-size: 1.05rem; display: flex; align-items: center; gap: 1rem; padding: 0.85rem 1.25rem; border-radius: 12px; margin: 0.35rem 0.85rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden;}
        
        /* Efecto Hover Magnético */
        .sidebar .nav-link::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, transparent 100%); transform: translateX(-100%); transition: transform 0.4s ease; z-index: 0; border-radius: 12px; }
        .sidebar .nav-link:hover::before { transform: translateX(0); }
        .sidebar .nav-link:hover { color: var(--color-white); transform: translateX(5px); text-shadow: 0 0 8px rgba(255,255,255,0.3); }
        
        /* Íconos interactivos */
        .sidebar .nav-link i { font-size: 1.5rem; color: var(--color-white); transition: all 0.3s ease; position: relative; z-index: 1; opacity: 0.9;}
        .sidebar .nav-link span { position: relative; z-index: 1; }
        .sidebar .nav-link:hover i { color: var(--color-green); transform: scale(1.15) rotate(-5deg); }
        
        /* Enlace Activo Estilizado */
        .sidebar .nav-link.active { background: rgba(31, 54, 74, 0.6); backdrop-filter: blur(10px); color: var(--color-white); font-weight: 600; border-left: none; box-shadow: 0 8px 20px rgba(0,0,0,0.15), inset 3px 0 0 var(--color-green); margin-left: 0.85rem; padding-left: 1.25rem; }
        .sidebar .nav-link.active i { color: var(--color-green); filter: drop-shadow(0 0 5px rgba(184, 214, 122, 0.5)); opacity: 1;}

        /* Títulos de Categoría Neón sutil */
        .sidebar-heading { font-size: 0.9rem; font-weight: 700; color: var(--color-green); text-transform: uppercase; letter-spacing: 1px; margin-top: 2.2rem; margin-bottom: 1rem; padding: 0 1.5rem; display: flex; align-items: center; opacity: 1; }
        .sidebar-heading::after { content: ''; flex: 1; height: 1px; background: linear-gradient(90deg, rgba(184,214,122,0.4) 0%, transparent 100%); margin-left: 1rem; }

        /* Contenido Principal */
        .main-content { min-height: calc(100vh - 60px); padding: 2rem; }
        
        @media (max-width: 768px) {
            .institute-name-full { display: none; }
            .sidebar .nav-link { margin: 0.2rem 0.5rem; }
            .main-content { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navbar Top Fija -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" style="height: 65px;">
        <div class="container-fluid px-3">
            
            <!-- Botón hamburguesa móvil -->
            <button class="navbar-toggler border-0 shadow-none px-2 me-2 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Navegación">
                <span class="mdi mdi-menu fs-3" style="color: var(--color-green);"></span>
            </button>

            <!-- Logo y Título -->
            <a class="navbar-brand d-flex align-items-center gap-3 py-0" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" height="50" alt="Logo ITSSMT" style="object-fit: contain;">
                <div>
                    <span class="fw-bold institute-name institute-name-full d-md-block d-none">Instituto Tecnológico Superior de San Martin Texmelucan</span>
                    <span class="fw-bold institute-name d-block d-md-none">ITSSMT</span>
                </div>
            </a>

            <!-- Opciones Derecha -->
            <div class="d-flex align-items-center ms-auto">
                @auth
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->fotografia_perfil)
                        <img src="{{ Storage::url('perfiles/' . Auth::user()->fotografia_perfil) }}" class="rounded-circle border border-2 object-fit-cover" width="36" height="36" alt="Perfil" style="border-color: var(--color-green) !important;">
                        @else
                        <img src="{{ asset('assets/images/faces/face28.png') }}" class="rounded-circle border border-2" width="36" height="36" alt="Perfil" style="border-color: var(--color-green) !important;">
                        @endif
                        <span class="fw-semibold d-none d-sm-block text-white" style="font-size: 0.95rem;">{{ Auth::user()->nombre }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2" style="border-radius: 8px;">
                        <li><a class="dropdown-item py-2" href="{{ route('perfil.index') }}"><i class="mdi mdi-account-circle-outline me-2 text-muted"></i> Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger bg-transparent border-0"><i class="mdi mdi-logout me-2"></i> Cerrar Sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>

        </div>
    </nav>

    <!-- Estructura Principal -->
    <div class="container-fluid" style="padding-top: 65px;">
        <div class="row">
            
            <!-- Barra Lateral (Sidebar) -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse position-fixed pt-3 h-100 overflow-auto pb-5">
                
                <ul class="nav flex-column gap-1 px-2">
                    
                    <h6 class="sidebar-heading">Principal</h6>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('resumen') ? 'active' : '' }}" href="{{ route('resumen') }}">
                            <i class="mdi mdi-view-dashboard"></i> Resumen (Dashboard)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="mdi mdi-home"></i> Vista Inicio
                        </a>
                    </li>

                    <h6 class="sidebar-heading">Catálogos y Registros</h6>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('docentes.*') ? 'active' : '' }}" href="{{ route('docentes.index') }}">
                            <i class="mdi mdi-teach"></i> Docentes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('carreras.*') ? 'active' : '' }}" href="{{ route('carreras.index') }}">
                            <i class="mdi mdi-school"></i> Carreras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                            <i class="mdi mdi-account-group"></i> Estudiantes / Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tipousuarios.*') ? 'active' : '' }}" href="{{ route('tipousuarios.index') }}">
                            <i class="mdi mdi-account-card-details"></i> Tipos de Usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('actextraescolar.*') ? 'active' : '' }}" href="{{ route('actextraescolar.index') }}">
                            <i class="mdi mdi-calendar-check"></i> Actividades Extraesc.
                        </a>
                    </li>

                    <h6 class="sidebar-heading">Documentos</h6>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="exportarUsuariosPDF()">
                            <i class="mdi mdi-file-pdf-box" style="color: #ffb7b7;"></i> Reportes PDF
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="exportarUsuariosExcel()">
                            <i class="mdi mdi-file-excel-box" style="color: var(--color-green);"></i> Exportaciones Excel
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content bg-light">
                
                <!-- Encabezado de la Sección -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4 border-bottom pb-2">
                    <h4 class="fw-bold text-dark mb-0">Sistema de Actividades Extraescolares</h4>
                </div>

                <!-- Bloque inyectado de la vista hija -->
                @yield('content')

                <!-- Footer -->
                <footer class="mt-5 pt-3 d-flex justify-content-between text-muted small border-top">
                    <span>&copy; {{ date('Y') }} ITSSMT. Todos los derechos reservados.</span>
                    <span>Desarrollado con ❤️ por Sam and Moni</span>
                </footer>
            </main>

        </div>
    </div>

    <!-- Scripts Esenciales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    
    <!-- Librerías de Reportes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

    <script>
        async function fetchUsuariosData() {
            try {
                const response = await fetch("{{ route('reportes.usuarios-data') }}");
                if (!response.ok) throw new Error("Error en la respuesta del servidor");
                return await response.json();
            } catch (error) {
                console.error("Error al obtener datos:", error);
                alert("Hubo un error al obtener los datos para el reporte.");
                return null;
            }
        }

        async function exportarUsuariosPDF() {
            const data = await fetchUsuariosData();
            if (!data) return;

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4'); 

            doc.setFontSize(18);
            doc.setTextColor(31, 54, 74); 
            doc.text("Reporte General de Usuarios / Estudiantes", 14, 20);
            
            doc.setFontSize(10);
            doc.setTextColor(100);
            const fecha = new Date().toLocaleString();
            doc.text("Generado el: " + fecha, 14, 26);

            const rows = data.map(u => [
                u.num_control,
                `${u.nombre} ${u.apat} ${u.amat}`,
                u.carrera || 'N/A',
                u.generacion || 'N/A',
                u.turno || 'N/A',
                u.actividad ? u.actividad.nombre : 'Sin Actividad',
                u.tipo ? u.tipo.descripcion : 'N/A'
            ]);

            doc.autoTable({
                startY: 32,
                head: [['# Control', 'Nombre Completo', 'Carrera', 'Gen.', 'Turno', 'Actividad', 'Tipo']],
                body: rows,
                theme: 'striped',
                headStyles: { fillColor: [56, 97, 115] }, 
                styles: { fontSize: 9, cellPadding: 2 }
            });

            doc.save(`Reporte_Usuarios_${new Date().getTime()}.pdf`);
        }

        async function exportarUsuariosExcel() {
            const data = await fetchUsuariosData();
            if (!data) return;

            let csvContent = "\uFEFF"; 
            csvContent += "# Control,Nombre,Primer Apellido,Segundo Apellido,Carrera,Generacion,Turno,Actividad,Tipo\n";

            data.forEach(u => {
                const row = [
                    u.num_control,
                    u.nombre,
                    u.apat,
                    u.amat,
                    u.carrera || '',
                    u.generacion || '',
                    u.turno || '',
                    u.actividad ? u.actividad.nombre : '',
                    u.tipo ? u.tipo.descripcion : ''
                ];
                csvContent += row.map(val => `"${val}"`).join(",") + "\n";
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", `Exportacion_Usuarios_${new Date().getTime()}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

    @stack('scripts')
</body>
</html>
