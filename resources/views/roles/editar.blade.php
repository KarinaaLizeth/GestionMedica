@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/editar.css') }}">
@section('content')
<br>
<div class="formulario-editar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('rol.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Roles</a>
    </div>
    <div class="formulario-editar">
        <h3>Editar Rol</h3>
        <form method="POST" action="{{ route('rol.actualizar', $rol->id) }}">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="col-span-1 md:col-span-2"> 
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ $rol->nombre }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
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
