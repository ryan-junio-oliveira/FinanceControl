@props([
    'type' => 'info',
    'message' => '',
    'autoClose' => true,
    'duration' => 8000,
    'id' => null
])

@php
use Illuminate\Support\Str;

$alertId = $id ?? 'alert-' . Str::uuid();

$config = [
    'success' => [
        'bg' => 'bg-emerald-50/90 backdrop-blur-sm border-emerald-200',
        'text' => 'text-emerald-900',
        'icon' => 'text-emerald-500',
        'fa' => 'check-circle',
        'button' => 'text-emerald-600 hover:bg-emerald-100/70',
        'progress' => 'from-emerald-400 to-emerald-600',
        'accent' => 'border-l-4 border-emerald-500',
    ],
    'error' => [
        'bg' => 'bg-red-50/90 backdrop-blur-sm border-red-200',
        'text' => 'text-red-900',
        'icon' => 'text-red-500',
        'fa' => 'exclamation-circle',
        'button' => 'text-red-600 hover:bg-red-100/70',
        'progress' => 'from-red-400 to-red-600',
        'accent' => 'border-l-4 border-red-500',
    ],
    'warning' => [
        'bg' => 'bg-amber-50/90 backdrop-blur-sm border-amber-200',
        'text' => 'text-amber-900',
        'icon' => 'text-amber-500',
        'fa' => 'exclamation-triangle',
        'button' => 'text-amber-600 hover:bg-amber-100/70',
        'progress' => 'from-amber-400 to-amber-600',
        'accent' => 'border-l-4 border-amber-500',
    ],
    'info' => [
        'bg' => 'bg-blue-50/90 backdrop-blur-sm border-blue-200',
        'text' => 'text-blue-900',
        'icon' => 'text-blue-500',
        'fa' => 'info-circle',
        'button' => 'text-blue-600 hover:bg-blue-100/70',
        'progress' => 'from-blue-400 to-blue-600',
        'accent' => 'border-l-4 border-blue-500',
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
    class="alert-item group relative overflow-hidden border rounded-xl p-4 shadow-lg
           transition-all duration-300 ease-out
           animate-[fadeIn_.3s_ease-out]
           {{ $current['bg'] }} {{ $current['text'] }} {{ $current['accent'] }}"
>
    <div class="flex items-start gap-3">

        <div class="flex-shrink-0 mt-0.5">
            <x-fa-icon 
                name="{{ $current['fa'] }}" 
                class="h-5 w-5 {{ $current['icon'] }}" 
            />
        </div>

        <div class="flex-1 min-w-0">
            @if($message)
                <p class="text-sm font-semibold leading-relaxed">
                    {{ $message }}
                </p>
            @endif
            {{ $slot }}
        </div>

        <button
            type="button"
            class="alert-close flex-shrink-0 p-2 rounded-lg
                   transition-colors duration-200
                   focus:outline-none focus:ring-2 focus:ring-offset-1
                   {{ $current['button'] }}"
            aria-label="Fechar alerta"
        >
            <x-fa-icon name="times" class="h-4 w-4" />
        </button>
    </div>

    @if($autoClose)
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/5">
            <div
                class="alert-progress h-full bg-gradient-to-r {{ $current['progress'] }}"
                style="width:100%"
            ></div>
        </div>

        <script>
            (function() {
                const el = document.getElementById('{{ $alertId }}');
                if (!el) return;

                const duration = parseInt(el.dataset.duration || 0);
                const bar = el.querySelector('.alert-progress');

                if (bar) {
                    requestAnimationFrame(() => {
                        bar.style.transition = `width ${duration}ms linear`;
                        bar.style.width = '0%';
                    });
                }

                setTimeout(() => {
                    el.classList.add('opacity-0', 'translate-y-[-10px]');
                    setTimeout(() => el.remove(), 300);
                }, duration);

                el.querySelector('.alert-close')?.addEventListener('click', () => {
                    el.classList.add('opacity-0', 'translate-y-[-10px]');
                    setTimeout(() => el.remove(), 300);
                });
            })();
        </script>
    @endif
</div>