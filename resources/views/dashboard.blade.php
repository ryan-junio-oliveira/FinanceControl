@extends('layouts.app')

@section('page_title', 'Dashboard Financeiro')

@section('content')
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="col-span-2 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="card p-4">
            <div class="text-sm text-gray-500">Receitas (mês)</div>
            <div class="mt-2 text-2xl font-semibold text-green-600">R$ {{ number_format($totalRecipes ?? 0, 2, ',', '.') }}</div>
        </div>

        <div class="card p-4">
            <div class="text-sm text-gray-500">Despesas (mês)</div>
            <div class="mt-2 text-2xl font-semibold text-red-600">R$ {{ number_format($totalExpenses ?? 0, 2, ',', '.') }}</div>
        </div>

        <div class="card p-4">
            <div class="text-sm text-gray-500">Saldo</div>
            <div class="mt-2 text-2xl font-semibold">R$ {{ number_format($balance ?? 0, 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="card p-4">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Execução mensal</div>
                <div class="mt-2 text-lg font-semibold">{{ $executionPercent ?? 0 }}%</div>
            </div>
            <div class="w-1/2">
                <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-3 bg-red-500 rounded-full" style="width: {{ $executionPercent ?? 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-700">Últimas transações</h3>
            <ul class="mt-3 space-y-3">
                @forelse($recentTransactions as $t)
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-gray-100 flex items-center justify-center text-sm font-semibold text-gray-700">
                                {{ strtoupper(substr($t['name'],0,1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium">{{ $t['name'] }}</div>
                                <div class="text-xs text-gray-500">{{ 
                                    \Carbon\Carbon::parse($t['date'])->format('d/m/Y')
                                }}</div>
                            </div>
                        </div>
                        <div class="text-sm font-semibold {{ $t['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $t['type'] === 'income' ? '+' : '-' }}R$ {{ number_format($t['amount'], 2, ',', '.') }}
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-gray-500">Nenhuma transação recente.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
