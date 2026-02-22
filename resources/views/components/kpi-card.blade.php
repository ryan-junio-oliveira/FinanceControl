@props([
    'title',
    'value',
    'icon',
    'color' => 'emerald',
    'subtitle' => null,
])

<div title="{{ $title }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 border-l-{{ $color }}-500 card-hover animate-fade-in-up transition-transform duration-150 hover:scale-105">
    <div class="w-14 h-14 rounded-full bg-{{ $color }}-50 flex items-center justify-center text-{{ $color }}-600 border border-{{ $color }}-300 text-xl flex-shrink-0 shadow-inner">
        <i class="fa-solid fa-{{ $icon }}"></i>
    </div>
    <div class="min-w-0">
        <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">{{ $title }}</p>
        <p class="text-2xl font-bold text-gray-900 mt-0.5 truncate">{{ $value }}</p>
        @if($subtitle)
            <p class="text-xs text-gray-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
</div>
