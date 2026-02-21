@props([
    'title',
    'subtitle' => null,
    'createUrl' => null,
    'createLabel' => 'Novo',
    'createColor' => 'bg-emerald-600',
    'createIcon' => null,
])

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="flex items-center gap-3">
        {{ $slot }}

        @if($createUrl)
            <x-link variant="primary" href="{{ $createUrl }}" class="{{ $createColor }} text-white">
                @if($createIcon)
                    <i class="fa-solid {{ $createIcon }}"></i>
                @endif
                {{ $createLabel }}
            </x-link>
        @endif
    </div>
</div>