import './bootstrap';
import Alpine from 'alpinejs';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

import { Calendar } from '@fullcalendar/core';

window.Alpine = Alpine;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

Alpine.start();