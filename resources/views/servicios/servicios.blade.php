@extends('layouts.app')

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900 p-4">
    <div class="flex items-center justify-between flex-wrap md:flex-nowrap space-y-4 md:space-y-0 mb-4">
        <div class="flex items-center space-x-4">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar servicio">
            </div>
        </div>
        <div class="flex items-center">
            <a href="{{ route('servicios.crear') }}" class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #247b7b; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#83c5be'"  onmouseout="this.style.backgroundColor='#247b7b'">
            <ion-icon name="add-circle-outline" style="font-size: 1.3em; vertical-align: middle;" class="mr-1"></ion-icon>    
            Agregar Servicio
            </a>
        </div>
    </div>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase" style="background-color: #daffef;">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Precio</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $servicio)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">{{ $servicio->nombre }}</td>
                <td class="px-6 py-4">{{ $servicio->precio }}</td>
                <td class="px-6 py-4">{{ $servicio->descripcion }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('servicios.editar', $servicio->id) }}" class=" text-blue-600 dark:text-blue-500 hover:underline"><ion-icon name="create-outline"></ion-icon> Editar</a>
                    <form action="{{ route('servicios.eliminar', $servicio->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class=" text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?')"><ion-icon name="trash-outline"></ion-icon> Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

