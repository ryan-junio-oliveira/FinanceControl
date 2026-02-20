@extends('layouts.app')

@section('page_title', 'Receitas')

@section('content')
    <x-list-layout title="Receitas" subtitle="Gerencie todas as suas fontes de renda"
        create-url="{{ route('recipes.create') }}" create-label="Nova receita">

        <x-slot name="summary">
            <x-summary-cards>
                <x-card label="Total do período" :value="$recipes->sum('amount')" icon="fa-sack-dollar" color="bg-emerald-600" />
                <x-card label="Receitas" :value="$recipes->total()" icon="fa-list" color="bg-gray-700" />
                <x-card label="Fixas" :value="$recipes->where('fixed', true)->sum('amount')" icon="fa-calendar-days" color="bg-emerald-500" />
            </x-summary-cards>
        </x-slot>

        <x-slot name="controls">
            <x-table-controls placeholder="Pesquisar receitas..." :perPageOptions="[10, 20, 50, 100]" />
        </x-slot>

        {{-- Table --}}
        <div class="overflow-x-auto">
            @php
                $columns = [
                    ['label' => 'Nome', 'class' => 'text-left'],
                    ['label' => 'Valor', 'class' => 'text-right'],
                    ['label' => 'Fixa', 'class' => 'text-center'],
                    ['label' => 'Data', 'class' => 'text-left'],
                    ['label' => 'Ações', 'class' => 'text-right'],
                ];
            @endphp

            <x-table :columns="$columns" id="recipes-table" tbody-class="bg-white">

                @forelse($recipes as $recipe)
                    <tr class="group odd:bg-white even:bg-gray-50/50 hover:bg-emerald-50/40 transition-colors duration-150">

                        {{-- Nome --}}
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">
                                    {{ strtoupper(mb_substr($recipe->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">
                                        {{ $recipe->name }}
                                    </div>
                                    @if ($recipe->notes)
                                        <div class="text-xs text-gray-400 truncate max-w-[220px]">
                                            {{ $recipe->notes }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Valor --}}
                        <td class="px-6 py-3.5 text-right">
                            <span class="text-sm font-semibold text-emerald-600 tabular-nums">
                                R$ {{ number_format($recipe->amount, 2, ',', '.') }}
                            </span>
                        </td>

                        {{-- Fixa --}}
                        <td class="px-6 py-3.5 text-center">
                            @if ($recipe->fixed)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                    Fixa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 ring-1 ring-gray-200">
                                    <i class="fa-solid fa-arrows-rotate text-[10px]"></i>
                                    Variável
                                </span>
                            @endif
                        </td>

                        {{-- Data --}}
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1.5 text-sm text-gray-500">
                                <i class="fa-regular fa-calendar text-gray-400 text-xs"></i>
                                {{ $recipe->transaction_date ? \Carbon\Carbon::parse($recipe->transaction_date)->format('d/m/Y') : '—' }}
                            </span>
                        </td>

                        {{-- Ações --}}
                        <td class="px-6 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-150">

                                <a href="{{ route('recipes.edit', $recipe) }}"
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:bg-emerald-100 hover:text-emerald-600 transition-colors duration-150"
                                    title="Editar">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </a>

                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja remover esta receita?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:bg-red-100 hover:text-red-600 transition-colors duration-150"
                                        title="Remover">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 mb-4">
                                    <i class="fa-solid fa-sack-dollar text-2xl text-emerald-500"></i>
                                </div>
                                <p class="text-base font-semibold text-gray-900">
                                    Nenhuma receita encontrada
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Comece adicionando sua primeira fonte de renda.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>

        {{-- Pagination --}}
        <x-slot name="pagination">
            @if ($recipes->hasPages())
                <div class="flex items-center justify-between border-t border-gray-600 px-6 py-3 server-pager recipes">
                    <p class="text-sm text-gray-500">
                        Exibindo <span class="font-medium text-gray-900">{{ $recipes->firstItem() }}</span> a
                        <span class="font-medium text-gray-900">{{ $recipes->lastItem() }}</span> de
                        <span class="font-medium text-gray-900">{{ $recipes->total() }}</span> resultados
                    </p>
                    <div>
                        {{ $recipes->links() }}
                    </div>
                </div>
            @endif
        </x-slot>
    </x-list-layout>
@endsection
