@extends('cpanel.plantilla')
@section('content')

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Nueva Actividad Extraescolar</h4>

            <form action="{{ route('actextraescolar.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

@endsection
