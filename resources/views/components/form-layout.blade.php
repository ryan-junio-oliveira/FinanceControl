@props([
    'title',
    'subtitle' => null,
    'backUrl' => 'javascript:history.back()',
    'cancelUrl' => null,
    'submitLabel' => 'Salvar',
    'widthClass' => 'max-w-2xl',
    'formAction' => '#',
    'hasFiles' => false,
])

<div class="{{ $widthClass }} mx-auto">
    {{-- header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ $backUrl }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>

        <div>
            <h1 class="text-xl font-semibold text-gray-900">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-xs text-gray-400 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    <x-form-errors />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ $formAction }}" method="POST" @if($hasFiles) enctype="multipart/form-data" @endif class="divide-y divide-gray-100">
            @csrf

            <div class="p-6 space-y-5">
                {{ $slot }}
            </div>

            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                @isset($actions)
                    {{ $actions }}
                @else
                    <x-button-primary type="submit">{{ $submitLabel }}</x-button-primary>

                    @if($cancelUrl)
                        <a href="{{ $cancelUrl }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border bg-white text-sm text-gray-700 shadow-sm hover:bg-gray-50 transition">Cancelar</a>
                    @endif
                @endisset
            </div>
        </form>
    </div>
</div>