@extends('cpanel.plantilla')
@section('content')

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Editar Actividad Extraescolar</h4>

            <form action="{{ route('actextraescolar.update', $act->id_act) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control"
                           name="nombre" value="{{ $act->nombre }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>

@endsection
