@extends('layouts.app')

@section('page_title', 'Dashboard Financeiro')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 px-8 py-10">
    <div class="max-w-7xl mx-auto space-y-10">

        <!-- Header -->
        <div class="flex items-center justify-between bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl px-8 py-6 shadow-sm">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
                    Painel Financeiro
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Visão geral • {{ now()->format('d/m/Y') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('recipes.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Nova Receita
                </a>

                <a href="{{ route('expenses.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    <i class="fa-solid fa-receipt text-xs"></i>
                    Nova Despesa
                </a>
            </div>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Receita -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                            <i class="fa-solid fa-coins text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wider text-gray-400">Receitas (mês)</div>
                        </div>
                    </div>
                    <div class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">R$ {{ number_format($totalRecipes ?? 0, 2, ',', '.') }}</div>
                </div>
            </div>

            <!-- Despesas -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                            <i class="fa-solid fa-credit-card text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wider text-gray-400">Despesas (mês)</div>
                        </div>
                    </div>
                    <div class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">R$ {{ number_format($totalExpenses ?? 0, 2, ',', '.') }}</div>
                </div>
            </div>

            <!-- Saldo -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-wallet text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-wider text-gray-400">Saldo</div>
                        </div>
                    </div>
                    <div class="mt-1 text-3xl font-semibold tracking-tight {{ ($balance ?? 0) >= 0 ? 'text-gray-900' : 'text-rose-600' }}">R$ {{ number_format($balance ?? 0, 2, ',', '.') }}</div>
                </div>
            </div>

        </div>

        <!-- Execução -->
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-percent text-lg"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-400">Execução Mensal</div>
                        <div class="mt-3 text-4xl font-semibold tracking-tight text-gray-900">{{ $executionPercent ?? 0 }}%</div>
                    </div>
                </div>
            </div>

            <!-- Barra -->
            <div class="mt-6 w-full bg-gray-100 rounded-full h-2">
                <div class="h-2 rounded-full bg-gray-900 transition-all duration-500"
                     style="width: {{ $executionPercent ?? 0 }}%">
                </div>
            </div>
        </div>

        <!-- Gráfico + Transações -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Tendência -->
            <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-8 shadow-sm">

                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-gray-500"></i>
                        Tendência mensal
                    </h3>
                    <div class="text-xs text-gray-400">Últimos 12 meses</div>
                </div>

                <div id="chartOne"
                     class="mt-6 h-56"
                     data-series='@json($monthlySeries ?? [])'
                     data-categories='@json($monthlyCategories ?? [])'>
                </div>

                <div class="mt-10">
                    <h3 class="text-sm font-medium text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock text-gray-400"></i>
                        Últimas transações
                    </h3> 

                    <ul class="mt-4 divide-y divide-gray-100">
                        @forelse($recentTransactions as $t)
                            <li class="flex items-center justify-between py-4 px-2 rounded-xl hover:bg-gray-50 transition">

                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-sm font-semibold text-gray-700">
                                        {{ strtoupper(substr($t['name'], 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $t['name'] }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ \Carbon\Carbon::parse($t['date'])->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="text-sm font-semibold tracking-tight {{ $t['type'] === 'income' ? 'text-gray-900' : 'text-gray-500' }}">
                                    {{ $t['type'] === 'income' ? '+' : '-' }}
                                    R$ {{ number_format($t['amount'], 2, ',', '.') }}
                                </div>

                            </li>
                        @empty
                            <li class="py-6 text-sm text-gray-400">
                                Nenhuma transação recente.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Atalhos -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-8 shadow-sm">
                <h3 class="text-sm font-medium text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-rocket text-gray-500"></i>
                    Atalhos
                </h3> 

                <div class="mt-6 space-y-3">
                    <a href="{{ route('recipes.index') }}" class="block px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 transition text-sm text-gray-700">
                        <i class="fa-solid fa-wallet text-gray-400 mr-3"></i>
                        Ver receitas
                    </a>

                    <a href="{{ route('expenses.index') }}" class="block px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 transition text-sm text-gray-700">
                        <i class="fa-solid fa-credit-card text-gray-400 mr-3"></i>
                        Ver despesas
                    </a>

                    <a href="{{ route('monthly-controls.index') }}" class="block px-4 py-3 rounded-xl border border-gray-200 hover:bg-gray-50 transition text-sm text-gray-700">
                        <i class="fa-solid fa-calendar-days text-gray-400 mr-3"></i>
                        Controles mensais
                    </a>
                </div>

                <div class="mt-10 border-t border-gray-100 pt-6">
                    <div class="text-xs uppercase tracking-wider text-gray-400 mb-4">
                        Resumo rápido
                    </div>

                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Receitas</span>
                        <span class="font-medium text-gray-900">
                            R$ {{ number_format($totalRecipes ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-2 flex justify-between text-sm text-gray-600">
                        <span>Despesas</span>
                        <span class="font-medium text-gray-900">
                            R$ {{ number_format($totalExpenses ?? 0, 2, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-2 flex justify-between text-sm text-gray-600">
                        <span>Saldo</span>
                        <span class="font-medium text-gray-900">
                            R$ {{ number_format($balance ?? 0, 2, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Additional analytics: category-breakdowns, cards and comparisons -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Expenses by category (pie) -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-900">Despesas por categoria (mês)</div>
                    <div class="text-xs text-gray-400">{{ now()->format('M Y') }}</div>
                </div>
                <div id="chartExpensesByCategory" class="mt-4 h-56" data-series='@json($expensesCategorySeries ?? [])' data-labels='@json($expensesCategoryLabels ?? [])'></div>
            </div>

            <!-- Revenue by category (pie) -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-900">Receita por categoria (mês)</div>
                    <div class="text-xs text-gray-400">{{ now()->format('M Y') }}</div>
                </div>
                <div id="chartRevenueByCategory" class="mt-4 h-56" data-series='@json($recipesCategorySeries ?? [])' data-labels='@json($recipesCategoryLabels ?? [])'></div>
            </div>

            <!-- Cards overview -->
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-900">Cartões (faturas)</div>
                    <div class="text-xs text-gray-400">Total faturas</div>
                </div>

                <div class="mt-4">
                    <div class="text-3xl font-semibold">R$ {{ number_format($cardsTotal ?? 0, 2, ',', '.') }}</div>
                    <div class="text-xs text-gray-500 mt-1">Soma das faturas de todos os cartões</div>
                </div>

                <div id="chartCards" class="mt-6 h-40" data-labels='@json($creditCards->pluck("name") ?? [])' data-series='@json($creditCards->pluck("statement_amount") ?? [])'></div>

                <div class="mt-4 text-sm">
                    @forelse($creditCards as $c)
                        <div class="flex items-center justify-between py-1">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full" style="background-color: {{ $c->color ?? '#CBD5E1' }}"></div>
                                <div class="text-sm text-gray-700">{{ $c->name }}</div>
                            </div>
                            <div class="text-sm font-medium">R$ {{ number_format($c->statement_amount, 2, ',', '.') }}</div>
                        </div>
                    @empty
                        <div class="text-xs text-gray-400">Nenhum cartão cadastrado.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Combined comparisons -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-900">Despesa total (Despesas + Cartões) vs Receitas (mês)</div>
                    <div class="text-xs text-gray-400">Mês atual</div>
                </div>

                <div id="chartCombined" class="mt-6 h-56" data-labels='@json([now()->format("M/Y")])' data-series='@json([
                    ["name" => "Receitas", "data" => [ (float) ($totalRecipes ?? 0) ]],
                    ["name" => "Despesas + Cartões", "data" => [ (float) ($totalExpensesWithCards ?? 0) ]]
                ])'></div>

                <div class="mt-4 text-sm text-gray-600 flex gap-4">
                    <div>Receitas: <strong>R$ {{ number_format($totalRecipes ?? 0, 2, ',', '.') }}</strong></div>
                    <div>Despesas totais: <strong>R$ {{ number_format($totalExpensesWithCards ?? 0, 2, ',', '.') }}</strong></div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-6 shadow-sm transition">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-900">Top categorias (despesa)</div>
                    <div class="text-xs text-gray-400">Top 5</div>
                </div>

                <div id="chartTopCategories" class="mt-6 h-56" data-labels='@json($topExpenseCategories->pluck("category") ?? [])' data-series='@json($topExpenseCategories->pluck("total") ?? [])'></div>

                <div class="mt-4 text-sm text-gray-600">
                    @foreach($topExpenseCategories as $item)
                        <div class="flex items-center justify-between py-1">
                            <div class="text-sm">{{ $item['category'] }}</div>
                            <div class="text-sm font-medium">R$ {{ number_format($item['total'], 2, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
