@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">

@section('content')
<br>
<div class="formulario-agregar-container">
    <div class="informacion-header">
        <h3>Información</h3>
        <a href="{{ route('secretarias.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de secretarias</a>
    </div>
    <div class="formulario-agregar">
        <h3>Agregar Secretaría</h3>
        <form method="POST" action="{{ route('secretarias.store') }}">
            @csrf

            <!-- Nombres -->
            <div> 
                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" required />
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required />
            </div>

            <!-- Email -->
            <div class="col-span-1 md:col-span-2">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" required />
            </div>

            <!-- Password -->
            <div>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required />
            </div>

            <!-- Repeat Password -->
            <div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required />
            </div>

            <!-- Telefono -->
            <div class="col-span-1 md:col-span-2">
                <label for="telefono">Telefono</label>
                <input type="number" id="telefono" name="telefono" required />
            </div>

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>
<br><br>
@endsection
