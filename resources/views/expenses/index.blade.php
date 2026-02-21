@extends('layouts.app')

@section('page_title', __('Despesas'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Despesas')],
]" />

<x-list-layout
    title="{{ __('Despesas') }}"
    subtitle="{{ __('Gerencie suas saídas') }}"
    create-url="{{ route('expenses.create') }}"
    create-label="{{ __('Nova despesa') }}"
    create-color="bg-red-600"
>
    <x-slot name="controls">
        <x-table-controls
            placeholder="{{ __('Pesquisar despesas') }}"
            :perPageOptions="[10, 20, 50, 100]"
        />
    </x-slot>

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        {{ __('Nome Despesa') }}
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium text-right">
                        {{ __('Valor $') }}
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
                @forelse($expenses as $expense)
                    @include('expenses.partials.row', ['expense' => $expense])
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center">
                            <x-empty-state
                                :cols="5"
                                icon="wallet"
                                title="{{ __('Nenhuma despesa encontrada.') }}"
                                button-url="{{ route('expenses.create') }}"
                                button-label="{{ __('Nova despesa') }}"
                                button-class="bg-red-600"
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-slot name="pagination">
        @if ($expenses->hasPages())
            <div class="border-t border-default px-6 py-3">
                {{ $expenses->links() }}
            </div>
        @endif
    </x-slot>
</x-list-layout>
@endsection