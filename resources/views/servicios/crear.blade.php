@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">

@section('content')
<br>
<div class="formulario-agregar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('servicios.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de servicios</a>
    </div>
    <div class="formulario-agregar">
        <h3>Agregar Servicio</h3>
        <form method="POST" action="{{ route('servicios.store') }}">
            @csrf

            <!-- Nombre -->
            <div> 
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required />
            </div>

            <!-- Precio -->
            <div>
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" value="{{ old('precio') }}" required />
            </div>

            <!-- Cantidad -->
            <div>
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad') }}"/>
            </div>

            <!-- Descripción -->
            <div class="col-span-1 md:col-span-2">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required />
            </div>

            <button type="submit">Registrar</button>
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

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@endsection
