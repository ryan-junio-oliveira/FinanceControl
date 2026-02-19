@extends('layouts.app')

@section('page_title', 'Cartões de Crédito')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Cartões de Crédito</h1>
        <a href="{{ route('credit-cards.create') }}" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Novo cartão</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Nome</th>
                    <th class="px-4 py-3">Banco</th>
                    <th class="px-4 py-3">Fatura</th>
                    <th class="px-4 py-3">Limite</th>
                    <th class="px-4 py-3">Fech./Venc.</th>
                    <th class="px-4 py-3">Ativo</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($creditCards as $card)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $card->name }}</td>
                        <td class="px-4 py-3">{{ $card->bank?->name ?? $card->bank }}</td>
                        <td class="px-4 py-3">R$ {{ number_format($card->statement_amount, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $card->limit ? 'R$ ' . number_format($card->limit, 2, ',', '.') : '-' }}</td>
                        <td class="px-4 py-3">{{ $card->closing_day ?? '-' }} / {{ $card->due_day ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $card->is_active ? 'Sim' : 'Não' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('credit-cards.edit', $card) }}" class="text-blue-600 mr-3">Editar</a>
                            <form action="{{ route('credit-cards.destroy', $card) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover cartão?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-center text-gray-500" colspan="7">Nenhum cartão cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $creditCards->links() }}</div>
</div>
@endsection