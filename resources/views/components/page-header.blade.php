@props([
    'title',
    'subtitle' => null,
    'backUrl' => null,
    // breadcrumbs are rendered globally by layout
])

<div class="flex items-center gap-3 mb-6">
    @if($backUrl)
        <x-link variant="secondary" href="{{ $backUrl }}" class="h-9 w-9">
            <x-fa-icon name="arrow-left" class="h-4 w-4" />
        </x-link>
    @endif
    <div>
        <h1 class="text-xl font-semibold text-gray-900">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-xs text-gray-400 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
</div>
