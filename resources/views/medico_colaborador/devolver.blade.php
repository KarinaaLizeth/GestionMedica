@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Devolver Consulta</h2>
    <form action="{{ route('consultas.devolver', $consulta->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="comentarios">Comentarios</label>
            <textarea name="comentarios" id="comentarios" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Devolver Consulta</button>
    </form>
</div>
@endsection
