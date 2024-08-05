// importar el editor clásico de CKEditor
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// espera a que el contenido del DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function() {
    // inicializa CKEditor en el campo 'notas_padecimiento'
    ClassicEditor
        .create(document.querySelector('#notas_padecimiento'), {
            enterMode: 'paragraph',
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
            toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
        })
        .then(editor => {
            window.editorNotasPadecimiento = editor;
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#motivo_consulta'), {
            enterMode: 'paragraph',
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
            toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
        })
        .then(editor => {
            window.editorMotivoConsulta = editor;
        })
        .catch(error => {
            console.error(error);
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
                    <option value="">Seleccione un servicio</option>
                    ${Array.from(originalSelect.options).map(option => `
                        <option value="${option.value}" data-precio="${option.getAttribute('data-precio')}">${option.text}</option>
                    `).join('')}
                </select>
            </div>
            <div class="flex-1">
                <label for="cantidad_servicio">Cantidad</label>
                <input type="number" name="cantidad_servicio[]"  value="1" class="input-field"/>
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

        // asignar evento de cambio a los nuevos selects de servicio
        newFields.querySelector('.servicio-select').addEventListener('change', function(e) {
            const precioInput = e.target.closest('.servicios-field-group').querySelector('input[name="precio[]"]');
            const selectedOption = e.target.options[e.target.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            precioInput.value = precio; // asigna el precio correspondiente al servicio seleccionado
            cantidadInput.value = 1; // asigna la cantidad predeterminada de 1
        });
    });

    // evento para eliminar campos en las secciones de receta y servicios
    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('ion-icon[name="trash-outline"]')) {
            e.target.closest('.receta-field-group, .servicios-field-group').remove(); // elimina el grupo de campos
        }
    });

    // actualiza el precio basado en el servicio seleccionado para todos los selects de servicio
    document.querySelectorAll('.servicio-select').forEach(select => {
        select.addEventListener('change', function(e) {
            const precioInput = e.target.closest('.servicios-field-group').querySelector('input[name="precio[]"]');
            const selectedOption = e.target.options[e.target.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            precioInput.value = precio; // asigna el precio correspondiente al servicio seleccionado
            cantidadInput.value = 1; // asigna la cantidad predeterminada de 1
        });
    });

     // Validación del formulario
     const form = document.querySelector('form');
     form.addEventListener('submit', function(event) {
         const temperatura = document.getElementById('temperatura').value;
         const talla = document.getElementById('talla').value;
         const frecuencia_cardiaca = document.getElementById('frecuencia_cardiaca').value;
         const saturacion_oxigeno = document.getElementById('saturacion_oxigeno').value;
 
         if (temperatura > 99 || talla > 99 || frecuencia_cardiaca > 99 || saturacion_oxigeno > 99) {
             event.preventDefault();
 
             Swal.fire({
                 icon: 'error',
                 title: 'Valor fuera de rango',
                 text: 'Los valores de los signos vitales deben ser menores a 99.',
                 confirmButtonText: 'Aceptar'
             });
 
             if (temperatura > 99) document.getElementById('temperatura').value = '';
             if (talla > 99) document.getElementById('talla').value = '';
             if (frecuencia_cardiaca > 99) document.getElementById('frecuencia_cardiaca').value = '';
             if (saturacion_oxigeno > 99) document.getElementById('saturacion_oxigeno').value = '';
         }
     });

});
