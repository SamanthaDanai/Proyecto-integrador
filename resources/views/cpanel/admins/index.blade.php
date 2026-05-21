@extends('cpanel.plantilla')

@section('title', 'Gestión de Administradores')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0" style="border-radius: 25px;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="fw-800 text-navy mb-1"><i class="mdi mdi-account-shield text-teal me-2"></i> Administradores</h2>
                    <p class="text-muted fs-5 mb-0">Gestión de personal con acceso administrativo al sistema.</p>
                </div>
                <a href="{{ route('administradores.create') }}" class="btn btn-navy px-4 py-3 rounded-4 shadow-sm fw-bold">
                    <i class="mdi mdi-plus-circle me-1"></i> Nuevo Administrador
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 rounded-4 fw-bold">
                    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3 ps-4 rounded-start">N° Personal</th>
                            <th class="py-3">Nombre Completo</th>
                            <th class="py-3">Correo Institucional</th>
                            <th class="py-3 text-center rounded-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td class="ps-4 fw-bold text-teal">{{ $admin->num_control }}</td>
                                <td>
                                    <div class="fw-bold text-navy fs-5">{{ $admin->nombre }} {{ $admin->apat }} {{ $admin->amat }}</div>
                                    <span class="badge bg-light text-muted border">Acceso Total</span>
                                </td>
                                <td class="text-muted">{{ $admin->correo_inst }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('administradores.edit', $admin->num_control) }}" class="btn btn-outline-teal btn-sm px-3 rounded-3">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        @if(Auth::user()->num_control != $admin->num_control)
                                            <form action="{{ route('administradores.destroy', $admin->num_control) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-3" onclick="return confirm('¿Eliminar administrador?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="mdi mdi-account-off-outline fs-1 text-muted opacity-20"></i>
                                    <p class="fs-4 text-muted mt-3">No hay administradores registrados.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
