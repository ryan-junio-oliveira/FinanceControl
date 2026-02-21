@extends('layouts.app')

@section('page_title', __('Receitas'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Receitas')],
]" />

<x-list-layout
    title="{{ __('Receitas') }}"
    subtitle="{{ __('Gerencie todas as suas fontes de renda') }}"
    create-url="{{ route('recipes.create') }}"
    create-label="{{ __('Nova receita') }}"
>


    {{-- Controls --}}
    <x-slot name="controls">
        <x-table-controls
            placeholder="{{ __('Pesquisar receitas...') }}"
            :perPageOptions="[10, 20, 50, 100]"
        />
    </x-slot>

    {{-- Table --}}
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        {{ __('Nome') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium text-right">
                        {{ __('Valor') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium text-center">
                        {{ __('Fixa') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        {{ __('Data Transação') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium text-right">
                        <span class="sr-only">{{ __('Ações') }}</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($recipes as $recipe)
                    @include('recipes.partials.row', ['recipe' => $recipe])
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4">
                            <x-empty-state
                                :cols="5"
                                icon="sack-dollar"
                                title="{{ __('Nenhuma receita encontrada') }}"
                                message="{{ __('Comece adicionando sua primeira fonte de renda.') }}"
                                button-url="{{ route('recipes.create') }}"
                                button-label="{{ __('Nova receita') }}"
                                button-class="bg-emerald-600" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <x-slot name="pagination">
        @if ($recipes->hasPages())
            <div class="border-t border-default px-6 py-3">
                {{ $recipes->links() }}
            </div>
        @endif
    </x-slot>

</x-list-layout>
@endsection