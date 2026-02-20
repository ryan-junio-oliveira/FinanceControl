@extends('layouts.app')

@section('page_title', 'Cartões de Crédito')

@section('content')
    <x-list-layout title="Cartões de Crédito" subtitle="Gerencie seus cartões" create-url="{{ route('credit-cards.create') }}"
        create-label="Novo cartão" create-color="bg-brand-500">

        <x-slot name="controls">
            <x-table-controls placeholder="Pesquisar cartões" :perPageOptions="[10, 20, 50, 100]" />
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-700 text-sm font-medium">{{ strtoupper(mb_substr($card->name(), 0, 1)) }}</div>
                                <div class="min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $card->name() }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5 truncate max-w-[200px]">{{ $card->bankName() ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $card->bankName() ?? '-' }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm font-semibold tabular-nums text-gray-900">R$ {{ number_format($card->statementAmount(), 2, ',', '.') }}</span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="text-sm tabular-nums text-gray-700">{{ $card->limit() ? 'R$ ' . number_format($card->limit(), 2, ',', '.') : '-' }}</span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $card->closingDay() ?? '-' }} / {{ $card->dueDay() ?? '-' }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            @if($card->is_active)
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

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('credit-cards.edit', ['id' => $card->id]) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" aria-label="Editar cartão {{ $card->name() }}">
                                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                                </a>

                                <form action="{{ route('credit-cards.destroy', ['id' => $card->id]) }}" method="POST" onsubmit="return confirm('Remover cartão?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" aria-label="Remover cartão {{ $card->name() }}">
                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M21 6H3m16 0l-1 14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2L3 6"/></svg>
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
                                    <a href="{{ route('credit-cards.create') }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded bg-brand-500 text-white text-sm">Novo
                                        cartão</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>

        <x-slot name="pagination">
            @if ($creditCards->hasPages())
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
