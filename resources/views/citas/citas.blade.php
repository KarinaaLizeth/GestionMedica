@extends('layouts.app')

@section('content')
<a href="{{ route('citas.crear') }}" class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'"  onmouseout="this.style.backgroundColor='#daffef'">
    Agendar Cita
</a>

<div class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="lg:w-7/12 md:w-9/12 sm:w-10/12 mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="flex items-center justify-between px-6 py-3 bg-gray-700">
                <button id="prevMonth" class="text-white">Anterior</button>
                <h2 id="currentMonth" class="text-white"></h2>
                <button id="nextMonth" class="text-white">Siguiente</button>
            </div>
            <div class="grid grid-cols-7 gap-2 p-4" id="calendar">
                <!-- Calendar Days Go Here -->
            </div>
            <div id="myModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50">
                <div class="modal-overlay absolute inset-0 bg-black opacity-50"></div>
                <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                    <div class="modal-content py-4 text-left px-6">
                        <div class="flex justify-between items-center pb-3">
                            <p class="text-2xl font-bold">Día seleccionado</p>
                            <button id="closeModal" class="modal-close px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring">✕</button>
                        </div>
                        <div id="modalDate" class="text-xl font-semibold"></div>
                        <div id="modalDetails" class="text-md mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const citas = @json($citas);

    function generateCalendar(year, month) {
        const calendarElement = document.getElementById('calendar');
        const currentMonthElement = document.getElementById('currentMonth');
        const firstDayOfMonth = new Date(Date.UTC(year, month, 1));
        const daysInMonth = new Date(Date.UTC(year, month + 1, 0)).getUTCDate();
        calendarElement.innerHTML = '';
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        currentMonthElement.innerText = `${monthNames[month]} ${year}`;
        const firstDayOfWeek = firstDayOfMonth.getUTCDay();
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center font-semibold';
            dayElement.innerText = day;
            calendarElement.appendChild(dayElement);
        });

        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDayElement = document.createElement('div');
            calendarElement.appendChild(emptyDayElement);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center py-2 border cursor-pointer';
            dayElement.innerText = day;

            const currentDate = new Date();
            const currentUTCDate = new Date(Date.UTC(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
            const dateToCheck = new Date(Date.UTC(year, month, day));
            if (dateToCheck.getTime() === currentUTCDate.getTime()) {
                dayElement.classList.add('bg-blue-500', 'text-white');
            }

            dayElement.addEventListener('click', () => {
                const selectedDate = new Date(Date.UTC(year, month, day));
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = selectedDate.toLocaleDateString(undefined, options);
                showModal(formattedDate, selectedDate);
            });

            calendarElement.appendChild(dayElement);
        }
    }

    const currentDate = new Date();
    let currentYear = currentDate.getUTCFullYear();
    let currentMonth = currentDate.getUTCMonth();
    generateCalendar(currentYear, currentMonth);

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    });

    function showModal(selectedDate, dateObject) {
        const modal = document.getElementById('myModal');
        const modalDateElement = document.getElementById('modalDate');
        const modalDetailsElement = document.getElementById('modalDetails');
        modalDateElement.innerText = selectedDate;

        const citasForSelectedDate = citas.filter(cita => {
            const citaDate = new Date(Date.UTC(new Date(cita.fecha).getFullYear(), new Date(cita.fecha).getMonth(), new Date(cita.fecha).getDate()));
            return citaDate.getTime() === dateObject.getTime();
        });

        let detailsContent = '';
        if (citasForSelectedDate.length > 0) {
            citasForSelectedDate.forEach(cita => {
                detailsContent += `<p><strong>Paciente:</strong> ${cita.paciente.nombres} ${cita.paciente.apellidos}</p>`;
                detailsContent += `<p><strong>Hora:</strong> ${cita.hora}</p>`;
                detailsContent += `<hr>`;
            });
        } else {
            detailsContent = '<p>No hay citas para esta fecha.</p>';
        }
        modalDetailsElement.innerHTML = detailsContent;

        modal.classList.remove('hidden');
    }

    function hideModal() {
        const modal = document.getElementById('myModal');
        modal.classList.add('hidden');
    }

    document.getElementById('closeModal').addEventListener('click', () => {
        hideModal();
    });
</script>
@endsection
