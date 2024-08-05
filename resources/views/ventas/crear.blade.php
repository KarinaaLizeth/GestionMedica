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
            <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
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
                                            <option value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" data-cantidad="{{ $servicio->cantidad }}" {{ $servicio->cantidad === 0 ? 'disabled' : '' }}>
                                                {{ $servicio->nombre }} {{ $servicio->cantidad === 0 ? '(No disponible)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" id="cantidad" name="cantidad[]" class="input-field cantidad-input" value="1" min="1" required/>
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
    function updatePrecio(selectElement) {
        const precioInput = selectElement.closest('tr').querySelector('input[name="precio[]"]');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const precio = selectedOption.getAttribute('data-precio');
        precioInput.value = precio; 
    }

    document.querySelector('.servicio-select').addEventListener('change', function(e) {
        updatePrecio(e.target);
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
                        <option value="${option.value}" data-precio="${option.getAttribute('data-precio')}" data-cantidad="${option.getAttribute('data-cantidad')}" ${option.getAttribute('data-cantidad') === "0" ? 'disabled' : ''}>
                            ${option.text} ${option.getAttribute('data-cantidad') === "0" ? '(No disponible)' : ''}
                        </option>
                    `).join('')}
                </select>
            </td>
            <td>
                <input type="number" name="cantidad[]" value="1" class="input-field cantidad-input" min="1" required/>
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
            updatePrecio(e.target);
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('ion-icon[name="trash-outline"]')) {
            e.target.closest('tr').remove();
        }
    });

    document.getElementById('ventaForm').addEventListener('submit', function(e) {
        const cantidadInputs = document.querySelectorAll('.cantidad-input');
        for (const cantidadInput of cantidadInputs) {
            const tr = cantidadInput.closest('tr');
            const selectElement = tr.querySelector('.servicio-select');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const cantidadDisponible = parseInt(selectedOption.getAttribute('data-cantidad'), 10);
            const cantidadSeleccionada = parseInt(cantidadInput.value, 10);

            if (cantidadSeleccionada > cantidadDisponible) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Cantidad Insuficiente',
                    text: `Solo hay ${cantidadDisponible} unidades disponibles para el servicio: ${selectedOption.text}`
                });
                return false;
            }
        }
    });
});
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Errores de Validación',
            html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@endpush
