@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/editar.css') }}">
@section('content')
<br>
<div class="formulario-editar-container">
    <div class="informacion-header">
        <h3>Información de la Secretaria</h3>
        <a href="{{ route('secretarias.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de secretarias</a>
    </div>
    <div class="formulario-editar">
        <h3>Editar Secretaria</h3>
        <form method="POST" action="{{ route('secretarias.actualizar', $secretaria->id) }}">
            @csrf
            @method('PUT')

            <!-- Nombres -->
            <div> 
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" value="{{ $secretaria->nombres }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ $secretaria->apellidos }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Correo -->
            <div>
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="{{ $secretaria->correo }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" value="{{ $secretaria->telefono }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            </div>


            <button type="submit">Actualizar</button>
        </form>
    </div>
</div>
@endsection
