@extends('layouts.app')

@section('page_title', 'Cartões de Crédito')

@section('content')
<x-list-layout title="Cartões de Crédito" subtitle="Gerencie seus cartões" create-url="{{ route('credit-cards.create') }}" create-label="Novo cartão" create-color="bg-brand-500">

    <x-slot name="controls">
        <x-table-controls placeholder="Pesquisar cartões" :perPageOptions="[10,20,50,100]" />
    </x-slot>

    @php
        $columns = [
            ['label' => 'Nome', 'class' => 'text-left'],
            ['label' => 'Banco', 'class' => 'text-left'],
            ['label' => 'Fatura', 'class' => 'text-right'],
            ['label' => 'Limite', 'class' => 'text-right'],
            ['label' => 'Fech./Venc.', 'class' => 'text-left'],
            ['label' => 'Ativo', 'class' => 'text-center'],
            ['label' => 'Ações', 'class' => 'text-right'],
        ];
    @endphp

    <div class="overflow-x-auto">
        <x-table compact :columns="$columns" id="credit-cards-table" tbody-class="bg-white divide-y divide-gray-100">
            @forelse($creditCards as $card)
                <tr class="group hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $card->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $card->bank?->name ?? $card->bank }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold">R$ {{ number_format($card->statement_amount, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">{{ $card->limit ? 'R$ ' . number_format($card->limit, 2, ',', '.') : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $card->closing_day ?? '-' }} / {{ $card->due_day ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">{{ $card->is_active ? 'Sim' : 'Não' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('credit-cards.edit', $card) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" aria-label="Editar cartão {{ $card->name }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M16.862 3.487a2.25 2.25 0 0 1 3.182 3.182L7.5 19.213l-4 1 1-4L16.862 3.487z" />
                                </svg>
                            </a>

                            <form action="{{ route('credit-cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Remover cartão?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" aria-label="Remover cartão {{ $card->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M3 6h18M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6M10 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="mx-auto max-w-md">
                            <div class="text-3xl text-gray-300 mb-3">—</div>
                            <p class="text-sm text-gray-500">Nenhum cartão cadastrado.</p>
                            <div class="mt-4">
                                <a href="{{ route('credit-cards.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-brand-500 text-white text-sm">Novo cartão</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <x-slot name="pagination">
        @if($creditCards->hasPages())
            <div class="flex items-center justify-between border-t border-gray-600 px-6 py-3 server-pager credit-cards">
                <p class="text-sm text-gray-500">
                    Exibindo <span class="font-medium text-gray-900">{{ $creditCards->firstItem() }}</span> a
                    <span class="font-medium text-gray-900">{{ $creditCards->lastItem() }}</span> de
                    <span class="font-medium text-gray-900">{{ $creditCards->total() }}</span> resultados
                </p>
                <div>
                    {{ $creditCards->links() }}
                </div>
            </div>
        @endif
    </x-slot>

</x-list-layout>
@endsection