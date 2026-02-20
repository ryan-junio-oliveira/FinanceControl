@props([
    'placeholder' => 'Pesquisar',
    'perPageOptions' => [10,20,50,100],
    'showPerPage' => true,
])

<form 
    method="GET" 
    role="search" 
    class="w-full bg-white p-4 rounded-xl border border-gray-200 shadow-sm"
    aria-label="Controles da tabela"
>
    <div class="flex flex-col lg:flex-row gap-3 lg:items-center">

        {{-- SEARCH --}}
        <div class="relative w-full lg:flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </div>

            <input
                id="q"
                name="q"
                type="search"
                value="{{ request('q') }}"
                placeholder="{{ $placeholder }}"
                autocomplete="off"
                class="w-full h-11 rounded-lg bg-gray-50 border border-gray-200 
                       pl-11 pr-10 text-sm placeholder-gray-400
                       focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 
                       transition-all duration-200 outline-none"
            />

            {{-- Clear (X) inside input --}}
            @if(request('q'))
                <a href="{{ url()->current() }}"
                   class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-red-500 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </a>
            @endif
        </div>

        {{-- RIGHT SIDE CONTROLS --}}
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

            {{-- PER PAGE --}}
            @if($showPerPage)
            <div class="relative w-full sm:w-auto">
                <select
                    name="per_page"
                    onchange="this.form.submit()"
                    class="appearance-none w-full sm:w-32 h-11 rounded-lg bg-gray-50 border border-gray-200 
                           px-4 pr-10 text-sm
                           focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10
                           transition outline-none"
                >
                    @foreach($perPageOptions as $opt)
                        <option value="{{ $opt }}" {{ request('per_page') == $opt ? 'selected' : '' }}>
                            {{ $opt }} / pág.
                        </option>
                    @endforeach
                </select>

                {{-- Custom arrow --}}
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
            @endif

            {{-- BUTTONS --}}
            <div class="flex gap-2 w-full sm:w-auto">

                {{-- Buscar --}}
                <button 
                    type="submit"
                    class="flex-1 sm:flex-none h-11 px-5 rounded-lg bg-cyan-800 text-white text-sm font-semibold 
                           hover:bg-cyan-500 focus:ring-4 focus:ring-brand-500/20 
                           transition shadow-sm cursor-pointer"
                >
                    Buscar
                </button>

                {{-- Limpar --}}
                @if(request()->has('q') || request()->has('per_page'))
                <a href="{{ url()->current() }}"
                   class="flex-1 sm:flex-none h-11 px-4 rounded-lg bg-gray-100 text-gray-600 text-sm font-medium 
                          hover:bg-gray-200 transition flex items-center justify-center">
                    Limpar
                </a>
                @endif

            </div>

        </div>
    </div>
</form>
