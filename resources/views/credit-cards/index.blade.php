@extends('layouts.app')

@section('page_title', __('Cartões de Crédito'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Cartões')],
]" />

    <x-list-layout title="{{ __('Cartões de Crédito') }}" subtitle="{{ __('Gerencie seus cartões') }}" create-url="{{ route('credit-cards.create') }}"
        create-label="{{ __('Novo cartão') }}" create-color="bg-brand-500">

        <x-slot name="controls">
            <x-table-controls placeholder="{{ __('Pesquisar cartões') }}" :perPageOptions="[10, 20, 50, 100]" />
        </x-slot>

        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
            <table class="w-full text-sm text-left rtl:text-right text-body">
                <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Nome') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Banco') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium text-right">{{ __('Fatura') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium text-right">{{ __('Limite') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium">{{ __('Fech./Venc.') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium text-center">{{ __('Ativo / Pago') }}</th>
                        <th scope="col" class="px-6 py-3 font-medium"><span class="sr-only">{{ __('Ações') }}</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($creditCards as $card)
                        @include('credit-cards.partials.row', ['card' => $card])
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4">
                                <x-empty-state
                                    :cols="7"
                                    icon="credit-card"
                                    title="{{ __('Nenhum cartão cadastrado.') }}"
                                    button-url="{{ route('credit-cards.create') }}"
                                    button-label="{{ __('Novo cartão') }}"
                                    button-class="bg-brand-500" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="pagination">
            @if ($creditCards->hasPages())
                <div class="border-t border-default px-6 py-3">
                    {{ $creditCards->links() }}
                </div>
            @endif
        </x-slot>

    </x-list-layout>
@endsection
