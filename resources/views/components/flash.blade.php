@php
$success = session('success');
$error = session('error') ?? session('danger');
@endphp

@if($success || $error)
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const message = @json($success ?? $error);
        const type = @json($success ? 'success' : 'error');
        if (window.TailAdmin && window.TailAdmin.toast && typeof window.TailAdmin.toast.show === 'function') {
            window.TailAdmin.toast.show({ type: type, message: message });
        } else {
            const el = document.createElement('div');
            el.className = 'fixed z-[9999] top-5 right-5 max-w-sm w-full pointer-events-auto';
            const ok = type === 'success';
            el.innerHTML = `<div class="flex items-center gap-3 rounded-2xl border px-4 py-3 shadow-lg text-sm font-medium ${ok ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800'}">${message}</div>`;
            document.body.appendChild(el);
            setTimeout(() => { el.style.transition = 'opacity .3s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 4200);
        }
    });
    </script>
@endif