@props([
    'placeholder' => 'Pesquisar',
    'perPage' => null,
    'perPageOptions' => [10,20,50,100],
    'showPerPage' => true,
])

<form method="GET" role="search" class="flex items-center gap-3 mb-4" aria-label="Table controls">
    <div class="flex-1 min-w-0">
        <label for="q" class="sr-only">Pesquisar</label>
        <div class="relative">
            <input id="q" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}" class="w-full rounded-lg border px-3 py-2 text-sm" aria-label="Pesquisar" />
            <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1 rounded bg-brand-500 text-white text-sm">Buscar</button>
        </div>
    </div>

    @if($showPerPage)
    <div>
        <label for="per_page" class="sr-only">Itens por página</label>
        <select id="per_page" name="per_page" onchange="this.form.submit()" class="rounded-lg border px-3 py-2 text-sm" aria-label="Itens por página">
            @foreach($perPageOptions as $opt)
                <option value="{{ $opt }}" {{ request('per_page') == $opt ? 'selected' : '' }}>{{ $opt }} / página</option>
            @endforeach
        </select>
    </div>
    @endif
</form>