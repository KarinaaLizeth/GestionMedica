@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">
@section('content')
<br>
<div class="section-container">
    <div class="informacion-header">
        <h3>Ventas</h3>
    </div>
    <div class="flex items-center">
        <a href="{{ route('ventas.crear') }}" class="text-white focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #247b7b; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#83c5be'" onmouseout="this.style.backgroundColor='#247b7b'">
            <ion-icon name="add-circle-outline" style="font-size: 1.3em; vertical-align: middle;" class="mr-1"></ion-icon>
            Agregar Venta
        </a>
    </div>
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $venta->total }}</td>
                        <td>
                            <a href="{{ route('ventas.ver', $venta->id) }}" class="btn-detalles">
                                <ion-icon name="eye-outline"></ion-icon> Ver Detalles
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
