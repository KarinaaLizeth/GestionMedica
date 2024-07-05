// importar el editor clásico de CKEditor
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// espera a que el contenido del DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function() {
    // inicializa CKEditor en el campo 'notas_padecimiento'
    ClassicEditor
        .create(document.querySelector('#notas_padecimiento'))
        .catch(error => {
            console.error(error); // muestra errores en la consola si los hay
        });

    // inicializa CKEditor en el campo 'motivo_consulta'
    ClassicEditor
        .create(document.querySelector('#motivo_consulta'))
        .catch(error => {
            console.error(error); // muestra errores en la consola si los hay
        });

    // oculta inicialmente todo el contenido de las secciones
    document.querySelectorAll('.section-content').forEach(section => {
        section.style.display = 'none';
    });

    // agrega eventos de clic para alternar la visibilidad de las secciones
    document.querySelectorAll('.section-title').forEach(title => {
        title.addEventListener('click', function() {
            const sectionContentId = this.getAttribute('data-target');
            const sectionContent = document.getElementById(sectionContentId);
            if (sectionContent.style.display === 'none' || sectionContent.style.display === '') {
                sectionContent.style.display = 'block'; // muestra la sección
            } else {
                sectionContent.style.display = 'none'; // oculta la sección
            }
        });
    });

    // función para agregar nuevos campos de medicación
    document.getElementById('addTimeButton').addEventListener('click', function() {
        const container = document.getElementById('receta-fields-container');
        const newFields = document.createElement('div');
        newFields.classList.add('receta-field-group', 'flex', 'w-full', 'gap-4');
        newFields.innerHTML = `
            <div class="flex-1">
                <label for="medicacion">Medicación</label>
                <input type="text" name="medicacion[]" required class="input-field"/>
            </div>
            <div class="flex-1">
                <label for="cantidad_medicamento">Cantidad</label>
                <input type="number" name="cantidad_medicamento[]" required class="input-field"/>
            </div>
            <div class="flex-1">
                <label for="frecuencia_medicamento">Frecuencia</label>
                <input type="text" name="frecuencia_medicamento[]" required class="input-field"/>
            </div>
            <div class="flex-1">
                <label for="duracion_medicamento">Duración</label>
                <input type="text" name="duracion_medicamento[]" required class="input-field"/>
            </div>
            <div class="flex-1 flex items-center">
                <button type="button" class="removeButton add"><ion-icon name="trash-outline"></ion-icon></button>
            </div>
        `;
        container.appendChild(newFields); // añade los nuevos campos al contenedor
    });

    // evento para eliminar campos de medicación
    document.getElementById('receta-fields-container').addEventListener('click', function(e) {
        if (e.target && e.target.matches('ion-icon[name="trash-outline"]')) {
            e.target.closest('.receta-field-group').remove(); // elimina el grupo de campos de medicación
        }
    });

    // función para agregar nuevos campos de servicio
    document.getElementById('addServicioButton').addEventListener('click', function() {
        const container = document.getElementById('servicios-fields-container');
        const originalSelect = document.querySelector('.servicio-select');
        const newFields = document.createElement('div');
        newFields.classList.add('servicios-field-group', 'flex', 'w-full', 'gap-4');
        newFields.innerHTML = `
            <div class="flex-1">
                <label for="servicio">Servicio</label>
                <select name="servicio[]" class="input-field servicio-select" required>
                    ${originalSelect.innerHTML}
                </select>
            </div>
            <div class="flex-1">
                <label for="cantidad_servicio">Cantidad</label>
                <input type="number" name="cantidad_servicio[]" required class="input-field"/>
            </div>
            <div class="flex-1">
                <label for="precio">Precio</label>
                <input type="number" name="precio[]" required class="input-field" readonly/>
            </div>
            <div class="flex-1 flex items-center">
                <button type="button" class="removeButton add"><ion-icon name="trash-outline"></ion-icon></button>
            </div>
        `;
        container.appendChild(newFields); // añade los nuevos campos al contenedor
    });

    // evento para eliminar campos en las secciones de receta y servicios
    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('ion-icon[name="trash-outline"]')) {
            e.target.closest('.receta-field-group, .servicios-field-group').remove(); // elimina el grupo de campos
        }
    });

    // actualiza el precio basado en el servicio seleccionado
    document.getElementById('servicios-fields-container').addEventListener('change', function(e) {
        if (e.target && e.target.matches('.servicio-select')) {
            const precioInput = e.target.closest('.servicios-field-group').querySelector('input[name="precio[]"]');
            const selectedOption = e.target.options[e.target.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            precioInput.value = precio; // asigna el precio correspondiente al servicio seleccionado
        }
    });
});