@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('budgets.index') }}" class="text-sm text-gray-500">Voltar</a>

    <div class="bg-white shadow-sm rounded-lg p-6 mt-4">
        <h1 class="text-xl font-semibold mb-2">{{ $budget->name }}</h1>
        <div class="text-sm text-gray-600 mb-4">{{ $budget->category?->name ?? 'Sem categoria' }} — {{ $budget->start_date->format('d/m/Y') }} até {{ $budget->end_date->format('d/m/Y') }}</div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <div class="text-sm text-gray-500">Planejado</div>
                <div class="text-2xl font-bold">R$ {{ number_format($budget->amount, 2, ',', '.') }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Gasto</div>
                <div class="text-2xl font-bold">R$ {{ number_format($budget->spent(), 2, ',', '.') }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Progresso</div>
                <div class="text-2xl font-bold">{{ $budget->progressPercent() }}%</div>
            </div>
        </div>

        <div class="mb-6">
            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                <div class="h-4 bg-green-500" style="width: {{ $budget->progressPercent() }}%"></div>
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-3">Lançamentos no período</h2>
        @php
            $expenses = \App\Models\Expense::where('organization_id', $budget->organization_id)
                ->whereBetween('transaction_date', [$budget->start_date->format('Y-m-d'), $budget->end_date->format('Y-m-d')]);
            if ($budget->category_id) $expenses->where('category_id', $budget->category_id);
            $expenses = $expenses->orderByDesc('transaction_date')->get();
        @endphp

        @if($expenses->count() > 0)
            <table class="w-full text-left text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Data</th>
                        <th class="px-4 py-3">Nome</th>
                        <th class="px-4 py-3">Categoria</th>
                        <th class="px-4 py-3">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $e)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $e->transaction_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $e->name }}</td>
                        <td class="px-4 py-3">{{ $e->category?->name ?? '-' }}</td>
                        <td class="px-4 py-3">R$ {{ number_format($e->amount, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-gray-500">Nenhum lançamento encontrado no período.</div>
        @endif
    </div>
</div>
@endsection
