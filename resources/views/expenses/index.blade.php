@extends('layouts.app')

@section('page_title', 'Despesas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Despesas</h1>
    <a href="{{ route('expenses.create') }}" class="px-4 py-2 rounded-lg bg-red-600 text-white">Nova despesa</a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
@endif

<table class="w-full text-sm rounded-lg overflow-hidden bg-white dark:bg-gray-800">
    <thead class="bg-gray-50 dark:bg-gray-900 text-left">
        <tr>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Valor</th>
            <th class="px-4 py-3">Fixa</th>
            <th class="px-4 py-3">Data</th>
            <th class="px-4 py-3">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($expenses as $expense)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $expense->name }}</td>
                <td class="px-4 py-3">R$ {{ number_format($expense->amount, 2, ',', '.') }}</td>
                <td class="px-4 py-3">{{ $expense->fixed ? 'Sim' : 'Não' }}</td>
                <td class="px-4 py-3">{{ $expense->transaction_date ? \Carbon\Carbon::parse($expense->transaction_date)->format('d/m/Y') : '-' }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 mr-3">Editar</a>
                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover despesa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Remover</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-4 py-6 text-center text-gray-500" colspan="5">Nenhuma despesa encontrada.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $expenses->links() }}
</div>
@endsection
