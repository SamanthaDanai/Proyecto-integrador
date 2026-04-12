@extends('cpanel.plantilla')

@section('content')

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Crear Tipo de Usuario</h4>

            <form action="{{ route('tipousuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Descripción del tipo de usuario</label>

                    <input type="text" class="form-control" name="descripcion" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

@endsection
