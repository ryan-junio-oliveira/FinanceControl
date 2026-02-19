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
            // fallback: create a simple static element so non-JS users still see the message
            const container = document.createElement('div');
            container.className = 'fixed z-50 top-6 right-6 max-w-sm w-full';
            container.innerHTML = `<div class="rounded-md ${type === 'success' ? 'bg-success-50 border border-success-100 p-3 text-sm text-success-700' : 'bg-error-50 border border-error-100 p-3 text-sm text-error-700'}">${message}</div>`;
            document.body.appendChild(container);
            setTimeout(() => container.remove(), 4500);
        }
    });
    </script>
@endif