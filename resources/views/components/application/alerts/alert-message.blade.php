@props([
    'type' => 'info',
    'message' => '',
    'autoClose' => true,
    'duration' => 8000,
    'id' => null
])

@php
$alertId = $id ?? 'alert-' . Str::uuid();

$config = [
    'success' => [
        'bg' => 'bg-emerald-50 border-emerald-200',
        'text' => 'text-emerald-800',
        'icon' => 'text-emerald-500',
        'fa' => 'check-circle',
        'button' => 'text-emerald-600 hover:text-emerald-800 hover:bg-emerald-100',
        'progress' => 'bg-emerald-400',
    ],
    'error' => [
        'bg' => 'bg-red-50 border-red-200',
        'text' => 'text-red-800',
        'icon' => 'text-red-500',
        'fa' => 'exclamation-circle',
        'button' => 'text-red-600 hover:text-red-800 hover:bg-red-100',
        'progress' => 'bg-red-400',
    ],
    'warning' => [
        'bg' => 'bg-amber-50 border-amber-200',
        'text' => 'text-amber-800',
        'icon' => 'text-amber-500',
        'fa' => 'exclamation-triangle',
        'button' => 'text-amber-600 hover:text-amber-800 hover:bg-amber-100',
        'progress' => 'bg-amber-400',
    ],
    'info' => [
        'bg' => 'bg-blue-50 border-blue-200',
        'text' => 'text-blue-800',
        'icon' => 'text-blue-500',
        'fa' => 'info-circle',
        'button' => 'text-blue-600 hover:text-blue-800 hover:bg-blue-100',
        'progress' => 'bg-blue-400',
    ],
];

$current = $config[$type] ?? $config['info'];
@endphp

<div
    id="{{ $alertId }}"
    role="alert"
    aria-live="polite"
    data-auto-close="{{ $autoClose ? 'true' : 'false' }}"
    data-duration="{{ (int)$duration }}"
    class="alert-item relative border rounded-lg p-4 shadow-sm transition-all duration-300 ease-in-out {{ $current['bg'] }} {{ $current['text'] }}"
>
    <div class="flex items-start gap-3">

        {{-- Icon segura --}}
        <x-fa-icon name="{{ $current['fa'] ?? 'info-circle' }}" class="h-5 w-5 mt-0.5 flex-shrink-0 {{ $current['icon'] }}" />

        <div class="flex-1 min-w-0">
            @if($message)
                <p class="text-sm font-medium break-words">
                    {{ $message }}
                </p>
            @endif
            {{ $slot }}
        </div>

        <button
            type="button"
            class="alert-close flex-shrink-0 p-1.5 rounded-md transition-colors duration-200 focus:outline-none {{ $current['button'] }}"
            aria-label="Fechar alerta"
        >
            <x-fa-icon name="times" class="h-4 w-4" />
        </button>
    </div>

    @if($autoClose)
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/10 rounded-b-lg overflow-hidden">
            <div
                class="alert-progress h-full {{ $current['progress'] }} opacity-40"
                style="width:100%"
            ></div>
        </div>

        <script>
            (function() {
                const el = document.getElementById('{{ $alertId }}');
                if (!el) return;
                const duration = {{ (int)$duration }};
                const bar = el.querySelector('.alert-progress');
                if (bar) {
                    requestAnimationFrame(() => {
                        bar.style.transition = `width ${duration}ms linear`;
                        bar.style.width = '0%';
                    });
                }
                setTimeout(() => {
                    el.style.transition = 'opacity .3s, transform .3s';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-10px)';
                    setTimeout(() => el.remove(), 300);
                }, duration);
            })();
        </script>
    @endif
</div>