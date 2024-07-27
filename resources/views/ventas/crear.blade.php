@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/crearventas.css') }}">

@section('content')
<br>
<div class="section-container">
    <div class="formulario-agregar-container">
        <div class="informacion-header">
            <h3>Realizar Venta</h3>
            <a href="{{ route('ventas.index') }}"><ion-icon name="arrow-back-outline" class="mr-2"></ion-icon>Inicio</a>
        </div>
        <div class="formulario-agregar">
            <form method="POST" action="{{ route('ventas.store') }}">
                @csrf
                <div class="section">
                    <h3 class="section-title"><ion-icon name="cart-outline"></ion-icon> Selección de Servicios/Productos</h3>
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th>Servicio/Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="servicio-fields-container">
                            <tr class="servicio-field-group">
                                <td>
                                    <select id="servicio" name="servicio[]" class="input-field servicio-select" required>
                                        <option value="">Seleccione un servicio</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}">{{ $servicio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" id="cantidad" name="cantidad[]" class="input-field" value="1" min="1" required/>
                                </td>
                                <td>
                                    <input type="number" id="precio" name="precio[]" required class="input-field" readonly/>
                                </td>
                                <td>
                                    <button type="button" id="addservicioButton" class="add"><ion-icon name="add-outline"></ion-icon></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn">Realizar Venta</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.servicio-select').addEventListener('change', function(e) {
        const precioInput = e.target.closest('tr').querySelector('input[name="precio[]"]');
        const selectedOption = e.target.options[e.target.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio');
        precioInput.value = precio; 
    });

    document.getElementById('addservicioButton').addEventListener('click', function() {
        const container = document.getElementById('servicio-fields-container');
        const originalSelect = document.querySelector('.servicio-select');
        const newRow = document.createElement('tr');
        newRow.classList.add('servicio-field-group');
        newRow.innerHTML = `
            <td>
                <select name="servicio[]" class="input-field servicio-select" required>
                    <option value="">Seleccione un servicio</option>
                    ${Array.from(originalSelect.options).map(option => `
                        <option value="${option.value}" data-precio="${option.getAttribute('data-precio')}">${option.text}</option>
                    `).join('')}
                </select>
            </td>
            <td>
                <input type="number" name="cantidad[]" value="1" class="input-field" min="1" required/>
            </td>
            <td>
                <input type="number" name="precio[]" required class="input-field" readonly/>
            </td>
            <td>
                <button type="button" class="removeButton add"><ion-icon name="trash-outline"></ion-icon></button>
            </td>
        `;
        container.appendChild(newRow);

        newRow.querySelector('.servicio-select').addEventListener('change', function(e) {
            const precioInput = e.target.closest('tr').querySelector('input[name="precio[]"]');
            const selectedOption = e.target.options[e.target.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            precioInput.value = precio;
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('ion-icon[name="trash-outline"]')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@endpush
