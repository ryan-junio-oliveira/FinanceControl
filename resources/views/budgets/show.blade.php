@extends('layouts.app')

@section('page_title', 'Orçamento')

@section('content')
<div class="max-w-4xl">

    {{-- Page header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('budgets.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-xl font-semibold text-gray-900">{{ $budget->name }}</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ $budget->category?->name ?? 'Sem categoria' }} — {{ $budget->start_date->format('d/m/Y') }} até {{ $budget->end_date->format('d/m/Y') }}</p>
        </div>
        <a href="{{ route('budgets.edit', $budget) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-cyan-800 text-white text-sm font-medium shadow-sm hover:bg-cyan-800 transition">
            <i class="fa-solid fa-pen-to-square text-sm"></i>
            Editar
        </a>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Planejado</p>
            <p class="text-2xl font-bold text-gray-900 mt-1 tabular-nums">R$ {{ number_format($budget->amount, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Gasto</p>
            <p class="text-2xl font-bold mt-1 tabular-nums {{ $budget->spent() > $budget->amount ? 'text-red-600' : 'text-gray-900' }}">R$ {{ number_format($budget->spent(), 2, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Progresso</p>
            <p class="text-2xl font-bold text-gray-900 mt-1 tabular-nums">{{ $budget->progressPercent() }}%</p>
        </div>
    </div>

    {{-- Progress bar --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
        @php $pct = min($budget->progressPercent(), 100); $over = $budget->progressPercent() > 100; @endphp
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">Utilização</span>
            <span class="text-sm font-bold {{ $over ? 'text-red-600' : 'text-gray-800' }}">{{ $budget->progressPercent() }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
            <div class="h-3 rounded-full transition-all {{ $over ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ $pct }}%"></div>
        </div>
        @if($over)
            <p class="text-xs text-red-500 mt-2">Orçamento excedido!</p>
        @endif
    </div>

    {{-- Transactions table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Lançamentos no período</h2>
        </div>

        @php
            $expenses = \App\Models\Expense::where('organization_id', $budget->organization_id)
                ->whereBetween('transaction_date', [$budget->start_date->format('Y-m-d'), $budget->end_date->format('Y-m-d')]);
            if ($budget->category_id) $expenses->where('category_id', $budget->category_id);
            $expenses = $expenses->orderByDesc('transaction_date')->get();
        @endphp

        @if($expenses->count() > 0)
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-700 text-xs font-semibold text-white uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Data</th>
                        <th class="px-6 py-3">Nome</th>
                        <th class="px-6 py-3">Categoria</th>
                        <th class="px-6 py-3 text-right">Valor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($expenses as $e)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $e->transaction_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $e->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $e->category?->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-right font-semibold tabular-nums text-gray-900">R$ {{ number_format($e->amount, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm text-gray-400">Nenhum lançamento encontrado no período.</p>
            </div>
        @endif
    </div>
</div>
@endsection
