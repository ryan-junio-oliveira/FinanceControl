import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
// FullCalendar
import { Calendar } from '@fullcalendar/core';



window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Chart imports
    if (document.querySelector('#chartOne')) {
        import('./components/chart/chart-1').then(module => module.initChartOne());
    }
    if (document.querySelector('#chartTwo')) {
        import('./components/chart/chart-2').then(module => module.initChartTwo());
    }
    if (document.querySelector('#chartThree')) {
        import('./components/chart/chart-3').then(module => module.initChartThree());
    }
    if (document.querySelector('#chartSix')) {
        import('./components/chart/chart-6').then(module => module.initChartSix());
    }
    if (document.querySelector('#chartEight')) {
        import('./components/chart/chart-8').then(module => module.initChartEight());
    }
    if (document.querySelector('#chartThirteen')) {
        import('./components/chart/chart-13').then(module => module.initChartThirteen());
    }

    // new dashboard charts
    if (document.querySelector('#chartExpensesByCategory')) {
        import('./components/chart/chart-pie').then(module => module.initPie('chartExpensesByCategory'));
    }
    if (document.querySelector('#chartRevenueByCategory')) {
        import('./components/chart/chart-pie').then(module => module.initPie('chartRevenueByCategory'));
    }
    if (document.querySelector('#chartCards')) {
        import('./components/chart/chart-cards').then(module => module.initCardsBar());
    }
    if (document.querySelector('#chartCombined')) {
        import('./components/chart/chart-combined').then(module => module.initCombined());
    }
    if (document.querySelector('#chartTopCategories')) {
        import('./components/chart/chart-top-categories').then(module => module.initTopCategories());
    }

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }
});
