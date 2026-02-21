@extends('layouts.app')

@section('page_title', 'Receitas')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Receitas'],
    ];
@endphp

<x-list-layout
    title="Receitas"
    subtitle="Gerencie todas as suas fontes de renda"
    create-url="{{ route('recipes.create') }}"
    create-label="Nova receita"
>

    {{-- Summary --}}
    <x-slot name="summary">
        <x-summary-cards>
            <x-card
                label="Total do período"
                :value="$recipes->sum('amount')"
                icon="fa-sack-dollar"
                color="bg-emerald-600"
            />
            <x-card
                label="Receitas"
                :value="$recipes->total()"
                icon="fa-list"
                color="bg-gray-700"
            />
            <x-card
                label="Fixas"
                :value="$recipes->where('fixed', true)->sum('amount')"
                icon="fa-calendar-days"
                color="bg-emerald-500"
            />
        </x-summary-cards>
    </x-slot>

    {{-- Controls --}}
    <x-slot name="controls">
        <x-table-controls
            placeholder="Pesquisar receitas..."
            :perPageOptions="[10, 20, 50, 100]"
        />
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

        <x-table
            compact
            :columns="$columns"
            id="recipes-table"
            tbody-class="bg-white divide-y divide-gray-100"
        >
            @forelse($recipes as $recipe)
                <tr class="group transition-colors hover:bg-gray-50/70">
                    {{-- Nome --}}
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                                {{ strtoupper(mb_substr($recipe->name, 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">
                                    {{ $recipe->name }}
                                </div>

                                @if ($recipe->notes)
                                    <div class="text-xs text-gray-500 mt-0.5 truncate max-w-[200px]">
                                        {{ $recipe->notes }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Valor --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <span class="text-sm font-semibold tabular-nums text-gray-900">
                            R$ {{ number_format($recipe->amount, 2, ',', '.') }}
                        </span>
                    </td>

                    {{-- Fixa --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if ($recipe->fixed)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Sim
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                Não
                            </span>
                        @endif
                    </td>

                    {{-- Data --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $recipe->transaction_date
                            ? \Carbon\Carbon::parse($recipe->transaction_date)->format('d/m/Y')
                            : '-' }}
                    </td>

                    {{-- Ações --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                            {{-- Editar --}}
                            <x-button
                                variant="ghost"
                                href="{{ route('recipes.edit', $recipe) }}"
                                class="h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 p-0 focus:outline-none focus:ring-2 focus:ring-emerald-500/40"
                                aria-label="Editar receita {{ $recipe->name }}"
                            >
                                <x-fa-icon name="pen" class="h-3.5 w-3.5 text-current" />
                            </x-button>

                            {{-- Remover --}}
                            <form
                                action="{{ route('recipes.destroy', $recipe) }}"
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja remover esta receita?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-red-200"
                                    aria-label="Remover receita {{ $recipe->name }}"
                                >
                                    <x-fa-icon name="trash" class="h-3.5 w-3.5 text-current" />
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
                                <x-fa-icon name="folder-open" class="h-7 w-7 text-gray-400" />
                            </div>

                            <p class="text-base font-medium text-gray-900">
                                Nenhuma receita encontrada
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Comece adicionando sua primeira fonte de renda.
                            </p>

                            <x-button
                                variant="primary"
                                href="{{ route('recipes.create') }}"
                                class="mt-4 bg-emerald-600 hover:bg-emerald-700"
                            >
                                <x-fa-icon name="plus" class="h-4 w-4 text-current" />
                                Nova receita
                            </x-button>
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
                    Exibindo
                    <span class="font-medium text-gray-900">{{ $recipes->firstItem() }}</span>
                    a
                    <span class="font-medium text-gray-900">{{ $recipes->lastItem() }}</span>
                    de
                    <span class="font-medium text-gray-900">{{ $recipes->total() }}</span>
                    resultados
                </p>
                <div>
                    {{ $recipes->links() }}
                </div>
            </div>
        @endif
    </x-slot>

</x-list-layout>
@endsection