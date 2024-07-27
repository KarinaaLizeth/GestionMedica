import './bootstrap';
import './pages/citas';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import $ from 'jquery';
import 'datatables.net-dt/css/dataTables.dataTables.css';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';
import 'datatables.net/js/dataTables.js';
import 'datatables.net-buttons/js/dataTables.buttons.js';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';
import 'jszip';
import 'pdfmake';

import TomSelect from 'tom-select';

document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.js-tom-select');
    elements.forEach(element => {
        new TomSelect(element, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            maxOptions: 2000,
        });
    });
});



window.$ = window.jQuery = $;

window.Alpine = Alpine;

Alpine.start();

