@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/ver.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

@section('content')
<br>
<div class="section-container" id="content-to-print">
    <div class="formulario-agregar-container">
        <div class="informacion-header">
            <h3>Detalles de la Consulta</h3>
            <div class="right-links">
                <a href="{{ route('consultas.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Lista de Consultas</a>
                <a><button id="download-pdf" class="btn"><ion-icon name="download-outline"></ion-icon> Descargar PDF</button></a>
            </div>
        </div>
        <div class="formulario-agregar">
            <div class="info-header">
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
                    @if($cita)
                        <p><strong>Fecha y Hora de la Cita:</strong> {{ $cita->fecha }} {{ $cita->hora }}</p>
                    @else
                        <p><strong>Fecha y Hora de la Cita:</strong> No hay cita programada</p>
                    @endif
                </div>
            </div>
            <h3 class="h3infoconsulta">Información de la Consulta</h3>
            <div class="info-header">
                <div class="info-section">
                    <h4><strong>Motivo de la Consulta</strong></h4>
                    <p>{!! nl2br(e($consulta->motivo_consulta)) !!}</p>
                </div>
                <div class="info-section">
                    <h4><strong>Notas de Padecimiento</strong></h4>
                    <p>{!! nl2br(e($consulta->notas_padecimiento)) !!}</p>
                </div>
            </div>
            <div class="signos-vitales">
                <h4>Signos Vitales</h4>
                <div class="info-header">
                    <div class="info-section">
                        <p><strong>Talla:</strong> {{ $consulta->signosVitales->first()->talla }} cm</p>
                    </div>
                    <div class="info-section">
                        <p><strong>Temperatura:</strong> {{ $consulta->signosVitales->first()->temperatura }} °C</p>
                    </div>
                    <div class="info-section">
                        <p><strong>Frecuencia Cardíaca:</strong> {{ $consulta->signosVitales->first()->frecuencia_cardiaca }} bpm</p>
                    </div>
                    <div class="info-section">
                        <p><strong>Saturación de Oxígeno:</strong> {{ $consulta->signosVitales->first()->saturacion_oxigeno }} %</p>
                    </div>
                </div>
            </div>
            <div class="info-header">
                <div class="info-section">
                    <div class="recetas">
                        <h4>Receta</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Medicamento</th>
                                    <th>Cantidad</th>
                                    <th>Frecuencia</th>
                                    <th>Duración</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consulta->recetas as $index => $receta)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $receta->medicacion }}</td>
                                    <td>{{ $receta->cantidad_medicamento }}</td>
                                    <td>{{ $receta->frecuencia_medicamento }}</td>
                                    <td>{{ $receta->duracion_medicamento }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="info-section">
                    <div class="servicios">
                        <h4>Servicios</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consulta->serviciosConsulta as $index => $servicio)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $servicio->servicio->nombre }}</td>
                                    <td>{{ $servicio->cantidad_servicio }}</td>
                                    <td>{{ $servicio->precio }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="servicios">
                <table>
                    <thead>
                        <tr>
                            <th>Notas Receta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consulta->recetas as $receta)
                        <tr>
                            <td>{{ $receta->notas_receta }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th>Notas Servicios/Productos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consulta->serviciosConsulta as $servicio)
                        <tr>
                            <td>{{ $servicio->notas_servicio }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  
            
            <div class="info-header">
                <div class="info-section">
                    <div class="servicios">
                        <h4><strong>Venta</strong></h4>
                        @if($consulta->venta)
                        <table>
                            <thead>
                                <tr>
                                    <th>Servicio/Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consulta->venta->servicios as $index => $servicio)
                                <tr>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->pivot->cantidad }}</td>
                                    <td>{{ $servicio->pivot->precio }}</td>
                                    <td>{{ $servicio->pivot->subtotal }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>Total:</strong></td>
                                    <td><strong>{{ $consulta->venta->total }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        @else
                        <p>No hay venta registrada para esta consulta.</p>
                        @endif
                    </diiv>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('download-pdf').addEventListener('click', function() {
        // Ocultar los enlaces antes de generar el PDF
        document.querySelectorAll('.right-links a').forEach(function(link) {
            link.style.display = 'none';
        });
        
        var element = document.querySelector('.section-container');
        var opt = {
            margin:       0.3,
            filename:     'Consulta_Detalles.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 12 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save().then(function() {
            // Volver a mostrar los enlaces después de generar el PDF
            document.querySelectorAll('.right-links a').forEach(function(link) {
                link.style.display = 'inline';
            });
        });
    });
</script>

@endsection
