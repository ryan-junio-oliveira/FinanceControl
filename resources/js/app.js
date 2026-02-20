import './bootstrap';

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
            case 'success': return 'bg-emerald-50 border border-emerald-200 text-emerald-800';
            case 'error': return 'bg-red-50 border border-red-200 text-red-800';
            case 'warning': return 'bg-amber-50 border border-amber-200 text-amber-800';
            default: return 'bg-sky-50 border border-sky-200 text-sky-800';
        }
    }

    function show({ type = 'info', title = null, message = '', timeout = 4500 } = {}) {
        const c = ensureContainer();
        const el = document.createElement('div');
        el.className = `rounded-lg p-3 shadow-sm overflow-hidden transition transform duration-200 ease-out ${typeClasses(type)}`;
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