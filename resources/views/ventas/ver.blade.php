@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">

@section('content')
<br>
<div class="section-container">
    <div class="informacion-header">
        <h3>Detalles de la Venta</h3>
        <a href="{{ route('ventas.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Volver a Ventas</a>
    </div>

    <div class="venta-detalles-container">
        <div class="venta-info">
            @if($consulta)
                <div class="info-section">
                    <h4><strong>Doctor</strong></h4>
                    <p>{{ $consulta->doctor->nombres }} {{ $consulta->doctor->apellidos }}</p>
                    <p><ion-icon name="call-outline"></ion-icon>{{ $consulta->doctor->telefono }}</p>
                    <p><ion-icon name="mail-outline"></ion-icon>{{ $consulta->doctor->correo }}</p>
                </div>
                <div class="info-section">
                    <h4><strong>Paciente</strong></h4>
                    <p>{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</p>
                    <p><ion-icon name="call-outline"></ion-icon>{{ $consulta->paciente->telefono }}</p>
                    <p><ion-icon name="mail-outline"></ion-icon>{{ $consulta->paciente->correo }}</p>
                </div>
                <div class="info-section">
                    <h4><strong>Consulta</strong></h4>
                    <p><strong>Fecha y Hora de la Consulta:</strong> {{ $consulta->created_at->format('Y-m-d H:i') }}</p>
                </div>
            @else
                <div class="info-section">
                    <p><strong>Fecha:</strong> {{ $venta->created_at->format('Y-m-d') }}</p>
                    <p><strong>Hora:</strong> {{ $venta->created_at->format('H:i') }}</p>
                </div>
            @endif
        </div>
        <div class="venta-resumen">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Servicio/Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->servicios as $index => $servicio)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->pivot->cantidad }}</td>
                            <td>${{ $servicio->pivot->precio }}</td>
                            <td>${{ $servicio->pivot->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>SubTotal</strong></td>
                        <td>${{ $venta->total }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td class="total"><strong>${{ $venta->total }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
