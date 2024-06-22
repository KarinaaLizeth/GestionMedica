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

            <!-- Nombres -->
            <div> 
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required />
            </div>

            <!-- Precio -->
            <div>
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" required />
            </div>

            <!-- Descripcion -->
            <div  class="col-span-1 md:col-span-2">
                <label for="descripcion">Descripcion</label>
                <input type="text" id="descripcion" name="descripcion" required />
            </div>

            

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>
<br><br>
@endsection
