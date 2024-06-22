@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crear.css') }}">

@section('content')
<br>
<div class="formulario-agregar-container">
    <div class="informacion-header">
        <h3>Información Personal</h3>
        <a href="{{ route('pacientes.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de pacientes</a>
    </div>
    <div class="formulario-agregar">
        <h3>Agregar Paciente</h3>
        <form method="POST" action="{{ route('pacientes.store') }}">
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

            <!-- Teléfono -->
            <div>
                <label for="telefono">Teléfono</label>
                <input type="number" id="telefono" name="telefono" required />
            </div>

            <!-- Teléfono Emergencia -->
            <div>
                <label for="telefono_emergencia">Teléfono de Emergencia</label>
                <input type="number" id="telefono_emergencia" name="telefono_emergencia" required />
            </div>

            <!-- Género -->
            <div>
                <label for="genero">Género</label>
                <div class="genero-opciones">
                    <label><input type="radio" name="genero" value="femenino" required> Femenino</label>
                    <label><input type="radio" name="genero" value="masculino" required> Masculino</label>
                    <label><input type="radio" name="genero" value="otro" required> Otro</label>
                </div>
            </div>

            <!-- Fecha de nacimiento -->
            <div>
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <!-- Altura -->
            <div>
                <label for="altura">Altura (en centímetros)</label>
                <input type="number" id="altura" name="altura" required />
            </div>

            <!-- Peso -->
            <div>
                <label for="peso">Peso (en kilogramos)</label>
                <input type="number" step="0.01" id="peso" name="peso" required />
            </div>

            <!-- Tipo sangre -->
            <div>
                <label for="sangre">Tipo de sangre</label>
                <select id="sangre" name="sangre">
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                </select>
            </div>

            <!-- Alergias -->
            <div>
                <label for="alergias">Alergias</label>
                <textarea id="alergias" name="alergias"></textarea>
            </div>

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>
<br><br>
@endsection
