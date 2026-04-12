@extends('cpanel.plantilla')

@section('content')

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Editar Tipo de Usuario</h4>

            <form action="{{ route('actextraescolar.update', $tipo->id_tipo) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="{{ $tipo->nombre }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>

@endsection
<div>
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
</div>
