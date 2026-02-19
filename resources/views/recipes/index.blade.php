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

            <x-table :columns="$columns" id="recipes-table" tbody-class="bg-white divide-y divide-gray-100">
                @forelse($recipes as $recipe)
                    <tr class="group transition-colors hover:bg-gray-50/70">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                                    {{ strtoupper(mb_substr($recipe->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $recipe->name }}
                                    </div>
                                    @if ($recipe->notes)
                                        <div class="text-xs text-gray-500 mt-0.5 truncate max-w-[200px]">
                                            {{ $recipe->notes }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-semibold tabular-nums text-gray-900">R$
                                {{ number_format($recipe->amount, 2, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if ($recipe->fixed)
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Sim
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                    Nao
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $recipe->transaction_date ? \Carbon\Carbon::parse($recipe->transaction_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div
                                class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('recipes.edit', $recipe) }}"
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/40"
                                    aria-label="Editar receita {{ $recipe->name }}">
                                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja remover esta receita?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-red-200"
                                        aria-label="Remover receita {{ $recipe->name }}">
                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 mb-4">
                                    <svg class="h-7 w-7 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                                    </svg>
                                </div>
                                <p class="text-base font-medium text-gray-900">Nenhuma receita encontrada</p>
                                <p class="text-sm text-gray-500 mt-1">Comece adicionando sua primeira fonte de
                                    renda.</p>
                                <a href="{{ route('recipes.create') }}"
                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium shadow-sm hover:bg-emerald-700 transition-colors">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Nova receita
                                </a>
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
