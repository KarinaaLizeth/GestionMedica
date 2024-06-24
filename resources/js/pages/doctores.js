document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addTimeButton').addEventListener('click', function() {
        var timeContainer = document.getElementById('timeContainer');

        // Crear el contenedor principal para los nuevos campos de tiempo y el botón de eliminación
        var timeInputContainer = document.createElement('div');
        timeInputContainer.classList.add('time-input-container');

        // Crear el sub-contenedor para los campos de tiempo
        var timeInputs = document.createElement('div');
        timeInputs.classList.add('time-input');

        // Clonar los elementos de tiempo "De"
        var fromLabel = document.createElement('label');
        fromLabel.textContent = 'De:';
        timeInputs.appendChild(fromLabel);

        var fromInput = document.createElement('input');
        fromInput.setAttribute('type', 'time');
        fromInput.setAttribute('name', 'available_time_from[]');
        fromInput.setAttribute('required', true);
        timeInputs.appendChild(fromInput);

        // Clonar los elementos de tiempo "A"
        var toLabel = document.createElement('label');
        toLabel.textContent = 'A:';
        timeInputs.appendChild(toLabel);

        var toInput = document.createElement('input');
        toInput.setAttribute('type', 'time');
        toInput.setAttribute('name', 'available_time_to[]');
        toInput.setAttribute('required', true);
        timeInputs.appendChild(toInput);

        // Añadir el sub-contenedor de campos de tiempo al contenedor principal
        timeInputContainer.appendChild(timeInputs);

        // Crear el contenedor para el botón de eliminación
        var deleteButtonContainer = document.createElement('div');
        deleteButtonContainer.classList.add('delete-button-container');

        // Crear el botón de eliminación
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.innerHTML = '<ion-icon name="close-outline"></ion-icon>';

        // Añadir evento para eliminar el conjunto de campos
        deleteButton.addEventListener('click', function() {
            timeContainer.removeChild(timeInputContainer);
        });

        // Añadir el botón de eliminación al contenedor del botón
        deleteButtonContainer.appendChild(deleteButton);

        // Añadir el contenedor del botón al contenedor principal
        timeInputContainer.appendChild(deleteButtonContainer);

        // Añadir los nuevos campos al contenedor principal
        timeContainer.appendChild(timeInputContainer);
    });
});