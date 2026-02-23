@props([
    'color' => 'bg-brand-500',
    'label' => '',
    'value' => null,
    'icon' => '',
])

<div class="relative overflow-hidden rounded-2xl {{ $color }} text-white p-5 shadow">
    <div class="relative z-10">
        <p class="text-[11px] font-semibold uppercase tracking-widest text-white/70">{{ $label }}</p>
        <p class="mt-2 text-2xl font-bold tabular-nums">R$ {{ number_format($value, 2, ',', '.') }}</p>
    </div>
    <i class="fa-solid {{ $icon }} absolute -right-2 top-1/2 -translate-y-1/2 text-[5rem] text-white/10 pointer-events-none"></i>
    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
</div>
