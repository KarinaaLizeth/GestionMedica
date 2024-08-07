@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">

@section('content')
<br>
<div class="formulario-agregar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('rol.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Roles</a>
    </div>
    <div class="formulario-agregar">
        <h3>Agregar Rol</h3>
        <form method="POST" action="{{ route('rol.store') }}">
            @csrf
            <!-- Nombres -->
            <div> 
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required />
            </div>
            <button type="submit">Agregar</button>
        </form>
    </div>
</div>
<br><br>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Errores de Validación',
            html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif
@endsection
