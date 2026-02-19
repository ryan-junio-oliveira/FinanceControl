import './bootstrap';
import Alpine from 'alpinejs';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

import { Calendar } from '@fullcalendar/core';
import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

window.Alpine = Alpine;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;

// Initialize Simple-DataTables for Flowbite-style tables
window.addEventListener('DOMContentLoaded', () => {
  const initOptions = {
    // client-side features disabled — server-side `x-table-controls` provides search/pagination
    searchable: false,
    paging: false,
    sortable: false,
    fixedHeight: false,
    perPage: 10,
    labels: {
      placeholder: 'Pesquisar...',
      perPage: 'por página',
      noRows: 'Nenhum registro encontrado',
      info: 'Mostrando {start} a {end} de {rows} entradas'
    }
  };

  const recipesTable = document.querySelector('#recipes-table');
  if (recipesTable) {
    // initialize for styling only; keep server-side controls visible
    new DataTable(recipesTable, initOptions);
  }

  const expensesTable = document.querySelector('#expenses-table');
  if (expensesTable) {
    // initialize for styling only; keep server-side controls visible
    new DataTable(expensesTable, initOptions);
  }
});

// --- Toast manager (TailAdmin.toast) ------------------------------------
window.TailAdmin = window.TailAdmin || {};
window.TailAdmin.toast = window.TailAdmin.toast || (function() {
    const containerId = 'global-toast-container';

    function ensureContainer() {
        let c = document.getElementById(containerId);
        if (!c) {
            c = document.createElement('div');
            c.id = containerId;
            c.className = 'fixed top-6 right-6 z-50 flex flex-col gap-3 w-full max-w-sm';
            document.body.appendChild(c);
        }
        return c;
    }

    function makeIcon(type) {
        if (type === 'success') return '<i class="fa-solid fa-check"></i>';
        if (type === 'error') return '<i class="fa-solid fa-triangle-exclamation"></i>';
        if (type === 'warning') return '<i class="fa-solid fa-exclamation"></i>';
        return '<i class="fa-solid fa-info"></i>';
    }

    function typeClasses(type) {
        switch(type) {
            case 'success': return 'bg-success-50 border border-success-100 text-success-700';
            case 'error': return 'bg-error-50 border border-error-100 text-error-700';
            case 'warning': return 'bg-warning-50 border border-warning-100 text-warning-700';
            default: return 'bg-blue-light-50 border border-blue-light-100 text-blue-light-700';
        }
    }

    function show({ type = 'info', title = null, message = '', timeout = 4500 } = {}) {
        const c = ensureContainer();
        const el = document.createElement('div');
        el.className = `rounded-lg p-3 shadow-theme-sm overflow-hidden transition transform duration-200 ease-out ${typeClasses(type)}`;
        el.style.opacity = '0';
        el.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="mt-0.5 w-9 h-9 rounded-full flex items-center justify-center text-sm">${makeIcon(type)}</div>
                <div class="flex-1">
                    ${ title ? `<div class="text-sm font-semibold text-gray-800">${title}</div>` : '' }
                    <div class="mt-1 text-sm text-gray-600">${message}</div>
                </div>
                <div class="flex-shrink-0">
                    <button class="text-gray-500 close-toast" aria-label="Fechar">&times;</button>
                </div>
            </div>
        `;

        c.prepend(el);
        // entrance
        requestAnimationFrame(() => { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; });

        const remove = () => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(() => el.remove(), 250);
        };

        const timer = setTimeout(remove, timeout);
        el.querySelector('.close-toast')?.addEventListener('click', function() { clearTimeout(timer); remove(); });
    }

    return { show, success: (msg, t) => show({ type: 'success', message: msg, timeout: t }), error: (msg, t) => show({ type: 'error', message: msg, timeout: t }), info: (msg, t) => show({ type: 'info', message: msg, timeout: t }), warning: (msg, t) => show({ type: 'warning', message: msg, timeout: t }) };
})();

Alpine.start();