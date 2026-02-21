@extends('layouts.app')

@section('content')
    <x-breadcrumbs :items="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Orçamentos')],
    ]" />
    <x-list-layout title="{{ __('Orçamentos') }}" subtitle="{{ __('Gerencie seus orçamentos') }}" create-url="{{ route('budgets.create') }}"
        create-label="{{ __('Novo orçamento') }}">


        <x-slot name="controls">
            <x-table-controls placeholder="{{ __('Pesquisar orçamentos') }}" :perPageOptions="[10, 20, 50, 100]" />
        </x-slot>

        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Nome') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Categoria') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Período') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Planejado') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Gasto') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Progresso') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium"><span class="sr-only">{{ __('Ações') }}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($budgets as $budget)
                        @include('budgets.partials.row', ['budget' => $budget])
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4">
                                <x-empty-state
                                    :cols="7"
                                    icon="chart-pie"
                                    title="{{ __('Nenhum orçamento encontrado.') }}"
                                    button-url="{{ route('budgets.create') }}"
                                    button-label="{{ __('Novo orçamento') }}" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="pagination">
            @if ($budgets->hasPages())
                <div class="border-t border-default px-6 py-3">
                    {{ $budgets->links() }}
                </div>
            @endif
        </x-slot>

    </x-list-layout>
@endsection
