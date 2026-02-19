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
            <a href="{{ $createUrl }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg {{ $createColor }} text-white font-medium text-sm shadow-sm hover:opacity-95 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500/30">
                @if($createIcon)
                    <i class="fa-solid {{ $createIcon }}"></i>
                @endif
                {{ $createLabel }}
            </a>
        @endif
    </div>
</div>