@extends('layouts.app')

@section('content')
<form class="max-w-sm mx-auto" method="POST" action="{{ route('secretarias.actualizar', $secretaria->id) }}">
    @csrf
    @method('PUT')
    <!--Nombres-->
    <div class="mb-5">
        <label for="nombres" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
        <input type="text" id="nombres" name="nombres" value="{{ $secretaria->nombres }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
    </div>

    <!--Apellidos-->
    <div class="mb-5">
        <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" value="{{ $secretaria->apellidos }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
    </div>

    <!--Correo-->
    <div class="mb-5">
        <label for="correo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
        <input type="email" id="correo" name="correo" value="{{ $secretaria->correo }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
    </div>

    <!--Teléfono-->
    <div class="mb-5">
        <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" value="{{ $secretaria->telefono }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
    </div>

    <button type="submit" class="text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'"  onmouseout="this.style.backgroundColor='#daffef'">Actualizar</button>
</form>
@endsection
