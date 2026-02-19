@props([
    'title',
    'subtitle' => null,
    'createUrl' => null,
    'createLabel' => 'Novo',
    'createColor' => 'bg-emerald-600',
    'createIcon' => null,
])

<div class="mx-auto max-w-6xl px-4 py-8 md:px-6 lg:px-8">
    <x-list-header :title="$title" :subtitle="$subtitle" :create-url="$createUrl" :create-label="$createLabel" :create-color="$createColor"
        :create-icon="$createIcon">
        @if (isset($headerActions))
            {{ $headerActions }}
        @endif
    </x-list-header>

    {{-- summary slot (optional) --}}
    @if (isset($summary))
        <div class="mb-6">{{ $summary }}</div>
    @endif

    {{-- controls slot (defaults to nothing) --}}
    @if (isset($controls))
        <div class="rounded-xl border border-gray-600 bg-white p-4 shadow-sm mb-4">{{ $controls }}</div>
    @endif

    {{-- main content (table) --}}
    <div class="rounded-xl border border-gray-600 bg-white shadow-sm overflow-hidden">{{ $slot }}</div>

    {{-- pagination slot (optional) --}}
    @if (isset($pagination))
        <div class="mt-4">{{ $pagination }}</div>
    @endif
</div>
