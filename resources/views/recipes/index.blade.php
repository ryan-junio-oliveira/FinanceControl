@extends('layouts.app')

@section('page_title', 'Receitas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Receitas</h1>
    <a href="{{ route('recipes.create') }}" class="px-4 py-2 rounded-lg bg-green-600 text-white">Nova receita</a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
@endif

<table class="w-full text-sm rounded-lg overflow-hidden bg-white dark:bg-gray-800">
    <thead class="bg-gray-50 dark:bg-gray-900 text-left">
        <tr>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Valor</th>
            <th class="px-4 py-3">Recebido</th>
            <th class="px-4 py-3">Data</th>
            <th class="px-4 py-3">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recipes as $recipe)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $recipe->name }}</td>
                <td class="px-4 py-3">R$ {{ number_format($recipe->amount, 2, ',', '.') }}</td>
                <td class="px-4 py-3">{{ $recipe->fixed ? 'Sim' : 'Não' }}</td>
                <td class="px-4 py-3">{{ $recipe->transaction_date ? \Carbon\Carbon::parse($recipe->transaction_date)->format('d/m/Y') : '-' }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('recipes.edit', $recipe) }}" class="text-blue-600 mr-3">Editar</a>
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover receita?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Remover</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-4 py-6 text-center text-gray-500" colspan="5">Nenhuma receita encontrada.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $recipes->links() }}
</div>
@endsection
