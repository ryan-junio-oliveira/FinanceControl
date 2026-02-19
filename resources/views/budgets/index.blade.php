@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Orçamentos</h1>
        <a href="{{ route('budgets.create') }}" class="px-4 py-2 rounded-lg bg-green-600 text-white">Novo orçamento</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm text-gray-600">
                <tr>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Categoria</th>
                    <th class="px-4 py-3">Período</th>
                    <th class="px-4 py-3">Planejado</th>
                    <th class="px-4 py-3">Gasto</th>
                    <th class="px-4 py-3">Progresso</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($budgets as $b)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $b->name }}</td>
                    <td class="px-4 py-3">{{ $b->category?->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $b->start_date->format('d/m/Y') }} — {{ $b->end_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">R$ {{ number_format($b->amount, 2, ',', '.') }}</td>
                    <td class="px-4 py-3">R$ {{ number_format($b->spent(), 2, ',', '.') }}</td>
                    <td class="px-4 py-3 w-48">
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-3 bg-green-500" style="width: {{ $b->progressPercent() }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ $b->progressPercent() }}%</div>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('budgets.show', $b) }}" class="text-gray-600 mr-2">Ver</a>
                        <a href="{{ route('budgets.edit', $b) }}" class="text-blue-600 mr-2">Editar</a>
                        <form action="{{ route('budgets.destroy', $b) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover orçamento?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Remover</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-4 py-6 text-center" colspan="7">Nenhum orçamento encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $budgets->links() }}</div>
</div>
@endsection
