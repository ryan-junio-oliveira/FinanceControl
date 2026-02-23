@extends('layouts.app')

@section('page_title', __('Investimentos'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Investimentos')],
]" />

<x-list-layout
    title="{{ __('Investimentos') }}"
    subtitle="{{ __('Gerencie seus investimentos') }}"
    create-url="{{ route('investments.create') }}"
    create-label="{{ __('Novo investimento') }}"
    create-color="bg-emerald-600"
>
    <x-slot name="controls">
        <x-table-controls
            placeholder="{{ __('Pesquisar investimentos') }}"
            :perPageOptions="[10, 20, 50, 100]"
        />
    </x-slot>

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        {{ __('Nome') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium text-right">
                        {{ __('Valor $') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium text-center">
                        {{ __('Fixo') }}
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
                @forelse($investments as $investment)
                    @include('investments.partials.row', ['investment' => $investment])
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center">
                            <x-empty-state
                                :cols="5"
                                icon="chart-line"
                                title="{{ __('Nenhum investimento encontrado.') }}"
                                button-url="{{ route('investments.create') }}"
                                button-label="{{ __('Novo investimento') }}"
                                button-class="bg-emerald-600"
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-slot name="pagination">
        @if ($investments->hasPages())
            <div class="border-t border-default px-6 py-3">
                {{ $investments->links() }}
            </div>
        @endif
    </x-slot>
</x-list-layout>
@endsection

