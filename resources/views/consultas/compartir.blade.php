@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Compartir Consulta</h3>
    <form action="{{ route('consultas.mostrarFormularioCompartir', $consulta->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="medico_colaborador_id">Seleccionar Colaborador</label>
            <select name="medico_colaborador_id" id="medico_colaborador_id" class="form-control" required>
                <option value="">Seleccione un colaborador</option>
                @foreach($medicoColaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ $colaborador->nombres }} {{ $colaborador->apellidos }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Compartir Consulta</button>
    </form>
</div>
@endsection
