@extends('layouts.app')

@section('page_title', 'Despesas')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Despesas'],
    ];
@endphp
    <x-list-layout title="Despesas" subtitle="Gerencie suas saídas" create-url="{{ route('expenses.create') }}"
        create-label="Nova despesa" create-color="bg-red-600">

        <x-slot name="summary">
            <x-summary-cards>
                <x-card label="Total do período" :value="$expenses->sum('amount')" icon="fa-wallet" color="bg-red-600" />
                <x-card label="Despesas" :value="$expenses->total()" icon="fa-list" color="bg-gray-700" />
                <x-card label="Fixas" :value="$expenses->where('fixed', true)->sum('amount')" icon="fa-repeat" color="bg-amber-500" />
            </x-summary-cards>
        </x-slot>

        <x-slot name="controls">
            <x-table-controls placeholder="Pesquisar despesas" :perPageOptions="[10, 20, 50, 100]" />
        </x-slot>

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

            <div class="overflow-x-auto">
                <x-table compact :columns="$columns" id="expenses-table" tbody-class="bg-white divide-y divide-gray-100">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50 focus-within:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $expense->name }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $expense->organization->nae ?? '' }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-semibold text-gray-900">R$
                                    {{ number_format($expense->amount, 2, ',', '.') }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($expense->fixed)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-success-50 text-success-700">Sim</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600">Não</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $expense->transaction_date ? \Carbon\Carbon::parse($expense->transaction_date)->format('d/m/Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <x-link variant="ghost" href="{{ route('expenses.edit', $expense) }}"
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/40"
                                        aria-label="Editar despesa {{ $expense->name }}">
                                        <x-fa-icon name="pen" class="w-4 h-4 text-current" />
                                    </x-link>

                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                        onsubmit="return confirm('Remover despesa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-red-200"
                                            aria-label="Remover despesa {{ $expense->name }}">
                                            <x-fa-icon name="trash" class="w-4 h-4 text-current" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="text-3xl text-gray-300 mb-3">—</div>
                                    <p class="text-sm text-gray-500">Nenhuma despesa encontrada.</p>
                                    <div class="mt-4">
                                        <x-link variant="primary" href="{{ route('expenses.create') }}" class="bg-red-600">
                                            Nova despesa
                                        </x-link>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </div>

        <x-slot name="pagination">
            @if ($expenses->hasPages())
                <div class="flex items-center justify-between border-t border-gray-600 px-6 py-3 server-pager expenses">
                    <p class="text-sm text-gray-500">
                        Exibindo <span class="font-medium text-gray-900">{{ $expenses->firstItem() }}</span> a
                        <span class="font-medium text-gray-900">{{ $expenses->lastItem() }}</span> de
                        <span class="font-medium text-gray-900">{{ $expenses->total() }}</span> resultados
                    </p>
                    <div>
                        {{ $expenses->links() }}
                    </div>
                </div>
            @endif
        </x-slot>
    </x-list-layout>
@endsection
