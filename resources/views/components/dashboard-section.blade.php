@props([
    'title' => null,
    'icon' => null,
    'color' => 'gray',
    'actions' => null,
    'class' => ''
])

@php
    // allow Tailwind color names like 'red','emerald','blue', etc.
    $stripe = "border-l-4 border-l-{$color}-500";
@endphp

<div class="bg-white rounded-xl shadow-md p-6 mt-6 {{ $stripe }} {{ $class }}">
    @if ($title)
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                @if($icon)
                    <i class="fa-solid fa-{{ $icon }} text-{{ $color }}-500 drop-shadow-sm"></i>
                @endif
                <h3 class="text-lg font-semibold text-gray-700">{{ $title }}</h3>
            </div>
            @if($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
