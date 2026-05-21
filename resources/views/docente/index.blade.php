@extends('layouts.docente')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Resumen -->
    <div class="col-md-12">
        <div class="card-custom" style="background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-teal) 100%); color: white;">
            <h1 class="fw-bold mb-2">Panel de Gestión Docente</h1>
            <p class="fs-5 opacity-75">Bienvenido al sistema de actividades extraescolares del ITSSMT. Desde aquí podrás gestionar tus grupos, capturar calificaciones y consultar eventos institucionales.</p>
        </div>
    </div>

    <!-- Grupos Asignados -->
    <div class="col-lg-8">
        <div class="card-custom">
            <h4 class="fw-bold mb-4"><i class="mdi mdi-google-classroom text-teal"></i> Mis Grupos Asignados</h4>
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($actividades->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">Actividad</th>
                                <th class="py-3 text-center">Horario</th>
                                <th class="py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actividades as $act)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-navy">{{ $act->nombre }}</div>
                                        <div class="small text-muted">ID: #{{ $act->id_act }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-3 py-2" style="border-radius: 8px;">
                                            {{ $act->horario ?? 'Sin horario' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('docente.grupo', $act->id_act) }}" class="btn-green btn-sm px-4">
                                            Gestionar Grupo <i class="mdi mdi-account-group ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="mdi mdi-folder-open-outline fs-1 text-muted opacity-25"></i>
                    <p class="fs-5 text-muted mt-3">No tienes actividades asignadas actualmente. El administrador te asignará una materia.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Rápida -->
    <div class="col-lg-4">
        <div class="card-custom">
            <h5 class="fw-bold mb-4"><i class="mdi mdi-account-tie text-teal"></i> Perfil Profesional</h5>
            
            <div class="mb-4">
                <label class="text-muted small fw-bold text-uppercase">Número de Empleado</label>
                <div class="fs-5 fw-bold text-navy">{{ $docente->no_empleado }}</div>
            </div>
            
            <div class="mb-4">
                <label class="text-muted small fw-bold text-uppercase">Nombre Completo</label>
                <div class="fs-5 fw-bold text-navy">{{ $docente->nombre }} {{ $docente->apet }} {{ $docente->amat }}</div>
            </div>

            <div class="mb-4">
                <label class="text-muted small fw-bold text-uppercase">Área Académica</label>
                <div class="fs-5 fw-bold text-navy">{{ $docente->area ?? 'General' }}</div>
            </div>

            <a href="{{ route('perfil.index') }}" class="btn btn-outline-navy w-100 py-3 rounded-4">
                Editar mi Perfil <i class="mdi mdi-cog ms-1"></i>
            </a>
        </div>
    </div>
</div>
@endsection
