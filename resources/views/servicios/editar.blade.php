@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/editar.css') }}">

@section('content')
<br>
<div class="formulario-editar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('servicios.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de servicios</a>
    </div>
    <div class="formulario-editar">
        <h3>Editar Servicio</h3>
        <form method="POST" action="{{ route('servicios.actualizar', $servicio->id) }}">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div> 
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ $servicio->nombre }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Precio -->
            <div>
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" value="{{ $servicio->precio }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>
            
            <!-- Cantidad -->
            <div>
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" value="{{ $servicio->cantidad }}" required />
            </div>

            <!-- Descripción -->
            <div class="full-width">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value="{{ $servicio->descripcion }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</div>

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
