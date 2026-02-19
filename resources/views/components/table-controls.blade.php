@props([
    'placeholder' => 'Pesquisar',
    'perPage' => null,
    'perPageOptions' => [10,20,50,100],
    'showPerPage' => true,
])

<form method="GET" role="search" class="flex items-center gap-3" aria-label="Controles da tabela">
    <div class="flex-1 min-w-0 relative">
        <label for="q" class="sr-only">Pesquisar</label>
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z"/>
            </svg>
        </div>
        <input
            id="q" name="q"
            value="{{ request('q') }}"
            placeholder="{{ $placeholder }}"
            class="w-full rounded-xl border border-gray-200 bg-white py-2 pl-9 pr-4 text-sm shadow-sm placeholder-gray-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
        />
    </div>

    @if($showPerPage)
    <div class="shrink-0">
        <label for="per_page" class="sr-only">Itens por página</label>
        <select
            id="per_page" name="per_page"
            onchange="this.form.submit()"
            class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
            aria-label="Itens por página"
        >
            @foreach($perPageOptions as $opt)
                <option value="{{ $opt }}" {{ request('per_page') == $opt ? 'selected' : '' }}>{{ $opt }} / pág.</option>
            @endforeach
        </select>
    </div>
    @endif

    <button type="submit" class="shrink-0 inline-flex items-center gap-1.5 rounded-xl bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500/30">
        Buscar
    </button>
</form>