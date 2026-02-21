@extends('layouts.app')

@section('page_title', 'Dashboard Financeiro')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Painel'],
    ];
@endphp
    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Painel</h1>
                <p class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Receitas --}}
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 border-l-emerald-500">
                <div
                    class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 text-xl flex-shrink-0">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Receitas</p>
                    <p class="text-2xl font-bold text-gray-800 mt-0.5 truncate">R$
                        {{ number_format($totalRecipes ?? 0, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Mês atual</p>
                </div>
            </div>

            {{-- Despesas --}}
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 border-l-red-500">
                <div
                    class="w-14 h-14 rounded-xl bg-red-50 flex items-center justify-center text-red-500 text-xl flex-shrink-0">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Despesas</p>
                    <p class="text-2xl font-bold text-gray-800 mt-0.5 truncate">R$
                        {{ number_format($totalExpenses ?? 0, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Mês atual</p>
                </div>
            </div>

            {{-- Faturas --}}
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 border-l-orange-500">
                <div
                    class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 text-xl flex-shrink-0">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Faturas (Cartões)</p>
                    <p class="text-2xl font-bold text-gray-800 mt-0.5 truncate">R$
                        {{ number_format($cardsTotal ?? 0, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total das faturas abertas</p>
                </div>
            </div>

            {{-- Investimentos --}}
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 border-l-violet-500">
                <div
                    class="w-14 h-14 rounded-xl bg-violet-50 flex items-center justify-center text-violet-500 text-xl flex-shrink-0">
                    <i class="fa-solid fa-piggy-bank"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Investimentos</p>
                    <p class="text-2xl font-bold text-gray-800 mt-0.5 truncate">R$
                        {{ number_format($totalInvestments ?? 0, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Categoria Investimentos</p>
                </div>
            </div>

            {{-- Despesas + Faturas --}}
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 border-l-rose-600">
                <div
                    class="w-14 h-14 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 text-xl flex-shrink-0">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Despesas + Faturas</p>
                    <p class="text-2xl font-bold text-gray-800 mt-0.5 truncate">R$
                        {{ number_format(($totalExpenses ?? 0) + ($cardsTotal ?? 0), 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total comprometido do mês</p>
                </div>
            </div>

            {{-- Saldo = Receitas − (Despesas + Faturas) --}}
            @php $bal = $balance ?? 0; @endphp
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4 items-center border-l-4 {{ $bal >= 0 ? 'border-l-blue-600' : 'border-l-red-600' }}">
                <div
                    class="w-14 h-14 rounded-xl {{ $bal >= 0 ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600' }} flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Saldo</p>
                    <p class="text-2xl font-bold mt-0.5 truncate {{ $bal >= 0 ? 'text-blue-700' : 'text-red-600' }}">R$
                        {{ number_format($bal, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Receitas &minus; (Despesas + Faturas)</p>
                </div>
            </div>

        </div>

        <!-- Execução -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-700">Execução mensal</h3>
                <span class="text-sm font-semibold text-gray-600">
                    {{ $executionPercent ?? 0 }}%
                </span>
            </div>

            <div class="mt-4 w-full bg-gray-200 rounded-full h-3">
                <div class="h-3 rounded-full bg-blue-600 transition-all duration-500"
                    style="width: {{ $executionPercent ?? 0 }}%">
                </div>
            </div>
        </div>

        <!-- CHART: Receitas vs Despesas — últimos 12 meses -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Receitas vs Despesas — últimos 12 meses</h3>
            <div class="relative" style="height: 280px;">
                <canvas id="chartMonthly"></canvas>
            </div>
        </div>

        <!-- CHART: Evolução do Saldo -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Evolução do Saldo — últimos 12 meses</h3>
            <div class="relative" style="height: 220px;">
                <canvas id="chartBalance"></canvas>
            </div>
        </div>

        <!-- CHARTS: Categorias (doughnut) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Despesas por Categoria -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Despesas por Categoria</h3>
                @if (count($expensesCategoryLabels ?? []) > 0)
                    <div class="relative flex justify-center" style="height: 260px;">
                        <canvas id="chartExpensesCategory"></canvas>
                    </div>
                @else
                    <div class="flex items-center justify-center h-40 text-gray-400 text-sm">
                        Nenhuma despesa registrada neste mês.
                    </div>
                @endif
            </div>

            <!-- Receitas por Categoria -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Receitas por Categoria</h3>
                @if (count($recipesCategoryLabels ?? []) > 0)
                    <div class="relative flex justify-center" style="height: 260px;">
                        <canvas id="chartRecipesCategory"></canvas>
                    </div>
                @else
                    <div class="flex items-center justify-center h-40 text-gray-400 text-sm">
                        Nenhuma receita registrada neste mês.
                    </div>
                @endif
            </div>
        </div>

        <!-- CHART: Orçamentos — resumo e utilização -->
        <div class="bg-white rounded-xl shadow-md p-6 mt-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Orçamentos</h3>
                    <p class="text-xs text-gray-400 mt-1">Visão geral dos orçamentos ativos no mês</p>
                </div>
                <div class="text-sm text-gray-600">
                    <div>Orçamentos ativos: <strong>{{ ($budgetsThisMonth ?? collect())->count() }}</strong></div>
                    <div>Total planejado: <strong>R$ {{ number_format($totalBudgetsPlanned ?? 0, 2, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            @if (($budgetsThisMonth ?? collect())->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-sm text-gray-500 mb-2">Planejado vs Gasto (soma dos orçamentos ativos)</div>
                        <div class="relative" style="height:220px; width:100%; max-width:360px;">
                            <canvas id="chartBudgetsSummary"></canvas>
                        </div>
                        <div class="mt-3 text-sm text-gray-500">Planejado: <strong>R$
                                {{ number_format($totalBudgetsPlanned ?? 0, 2, ',', '.') }}</strong> · Gasto: <strong>R$
                                {{ number_format($totalBudgetsSpent ?? 0, 2, ',', '.') }}</strong></div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-2">Utilização por orçamento (percentual)</div>
                        <div class="relative" style="height:320px;">
                            <canvas id="chartBudgetsProgress"></canvas>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center h-40 text-gray-400 text-sm">
                    Nenhum orçamento ativo neste mês.
                </div>
            @endif
        </div>

        <!-- CHART: Gastos diários do mês atual -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Gastos diários — {{ now()->format('F Y') }}</h3>
            <p class="text-xs text-gray-400 mb-4">Barras = valor do dia · Linha = acumulado</p>
            <div class="relative" style="height: 240px;">
                <canvas id="chartDailyExpenses"></canvas>
            </div>
        </div>

        <!-- CHART: Tendência das top 3 categorias de despesa -->
        @if (count($trendSeries ?? []) > 0)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Tendência — Top 3 Categorias de Despesa</h3>
                <p class="text-xs text-gray-400 mb-4">Evolução das maiores categorias nos últimos 6 meses</p>
                <div class="relative" style="height: 240px;">
                    <canvas id="chartCategoryTrend"></canvas>
                </div>
            </div>
        @endif

        <!-- CHART: Cartões de Crédito — Fatura vs Limite -->
        @if (($creditCards ?? collect())->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Faturas vs Limite — Cartões</h3>
                    <div class="relative" style="height: 220px;">
                        <canvas id="chartCards"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Utilização do Limite</h3>
                    <p class="text-xs text-gray-400 mb-4">% do limite comprometido por cartão</p>
                    <div class="relative" style="height: 220px;">
                        <canvas id="chartCardUtilization"></canvas>
                    </div>
                </div>
            </div>
        @endif

        <!-- Transações Recentes -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Últimas Transações</h3>
            @if (isset($recentTransactions) && $recentTransactions->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs uppercase tracking-wider text-gray-400">
                                <th class="pb-3 pr-4">Tipo</th>
                                <th class="pb-3 pr-4">Descrição</th>
                                <th class="pb-3 pr-4">Data</th>
                                <th class="pb-3 text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($recentTransactions as $tx)
                                <tr>
                                    <td class="py-3 pr-4">
                                        @if ($tx['type'] === 'income')
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                                <i class="fa-solid fa-arrow-up text-[10px]"></i> Receita
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                                <i class="fa-solid fa-arrow-down text-[10px]"></i> Despesa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 pr-4 font-medium text-gray-700">{{ $tx['name'] }}</td>
                                    <td class="py-3 pr-4 text-gray-400">
                                        {{ \Carbon\Carbon::parse($tx['date'])->format('d/m/Y') }}</td>
                                    <td
                                        class="py-3 text-right font-semibold {{ $tx['type'] === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $tx['type'] === 'income' ? '+' : '-' }} R$
                                        {{ number_format($tx['amount'], 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex items-center justify-center h-28 text-gray-400 text-sm">
                    Nenhuma transação encontrada.
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const COLORS = [
                '#3B82F6', '#F97316', '#10B981', '#8B5CF6', '#EC4899',
                '#EAB308', '#14B8A6', '#F43F5E', '#6366F1', '#84CC16',
            ];

            const GREEN = '#10B981';
            const RED = '#EF4444';
            const BLUE = '#3B82F6';

            const fmtBRL = v => 'R$ ' + (+v).toLocaleString('pt-BR', {
                minimumFractionDigits: 2
            });
            const ttBRL = ctx => ` ${ctx.dataset.label}: ${fmtBRL(ctx.parsed.y)}`;
            const ttBRLX = ctx => ` ${ctx.dataset.label}: ${fmtBRL(ctx.parsed.x)}`;

            // hex → rgba helper
            const hex2rgba = (hex, a) => {
                const r = parseInt(hex.slice(1, 3), 16);
                const g = parseInt(hex.slice(3, 5), 16);
                const b = parseInt(hex.slice(5, 7), 16);
                return `rgba(${r},${g},${b},${a})`;
            };

            // ------------------------------------------------------------------
            // 1. Receitas vs Despesas + Saldo — últimos 12 meses (Bar + Line)
            // ------------------------------------------------------------------
            const ctxMonthly = document.getElementById('chartMonthly');
            if (ctxMonthly) {
                const monthlyLabels = @json($monthlyCategories ?? []);
                const monthlySeries = @json($monthlySeries ?? []);
                const incomeData = monthlySeries.find(s => s.name === 'Receitas')?.data ?? [];
                const expenseData = monthlySeries.find(s => s.name === 'Despesas')?.data ?? [];

                new Chart(ctxMonthly, {
                    type: 'bar',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                                label: 'Receitas',
                                data: incomeData,
                                backgroundColor: hex2rgba(GREEN, 0.75),
                                borderColor: GREEN,
                                borderWidth: 1,
                                borderRadius: 4,
                                order: 2,
                            },
                            {
                                label: 'Despesas',
                                data: expenseData,
                                backgroundColor: hex2rgba(RED, 0.75),
                                borderColor: RED,
                                borderWidth: 1,
                                borderRadius: 4,
                                order: 2,
                            },
                            {
                                label: 'Saldo',
                                data: incomeData.map((v, i) => v - (expenseData[i] ?? 0)),
                                type: 'line',
                                borderColor: BLUE,
                                backgroundColor: hex2rgba(BLUE, 0.1),
                                borderWidth: 2,
                                pointRadius: 3,
                                fill: false,
                                tension: 0.35,
                                order: 1,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ttBRL
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => 'R$ ' + v.toLocaleString('pt-BR'),
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 2. Evolução do Saldo — área azul, vermelho quando negativo
            // ------------------------------------------------------------------
            const ctxBalance = document.getElementById('chartBalance');
            if (ctxBalance) {
                const monthlyLabels = @json($monthlyCategories ?? []);
                const monthlySeries = @json($monthlySeries ?? []);
                const incomeData = monthlySeries.find(s => s.name === 'Receitas')?.data ?? [];
                const expenseData = monthlySeries.find(s => s.name === 'Despesas')?.data ?? [];
                const balanceData = incomeData.map((v, i) => v - (expenseData[i] ?? 0));

                new Chart(ctxBalance, {
                    type: 'line',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: 'Saldo',
                            data: balanceData,
                            borderColor: BLUE,
                            backgroundColor: ctx => {
                                const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
                                g.addColorStop(0, hex2rgba(BLUE, 0.35));
                                g.addColorStop(1, hex2rgba(BLUE, 0));
                                return g;
                            },
                            borderWidth: 2,
                            pointRadius: 4,
                            fill: true,
                            tension: 0.4,
                            segment: {
                                borderColor: ctx => ctx.p1.parsed.y < 0 ? RED : BLUE,
                                backgroundColor: ctx => ctx.p1.parsed.y < 0 ? hex2rgba(RED, 0.15) :
                                    hex2rgba(BLUE, 0.2),
                            },
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ttBRL
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    callback: v => 'R$ ' + v.toLocaleString('pt-BR'),
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 3. Despesas por Categoria — Doughnut (tons de vermelho/laranja)
            // ------------------------------------------------------------------
            const ctxExpCat = document.getElementById('chartExpensesCategory');
            if (ctxExpCat) {
                const expLabels = @json($expensesCategoryLabels ?? []);
                const expData = @json($expensesCategorySeries ?? []);
                const expColors = ['#EF4444', '#F97316', '#DC2626', '#FB923C', '#B91C1C', '#FDBA74', '#991B1B',
                    '#FED7AA', '#7F1D1D', '#FCA5A5'
                ];
                new Chart(ctxExpCat, {
                    type: 'doughnut',
                    data: {
                        labels: expLabels,
                        datasets: [{
                            data: expData,
                            backgroundColor: expColors.slice(0, expLabels.length),
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${fmtBRL(ctx.parsed)}`
                                }
                            }
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 4. Receitas por Categoria — Doughnut (tons de verde)
            // ------------------------------------------------------------------
            const ctxRecCat = document.getElementById('chartRecipesCategory');
            if (ctxRecCat) {
                const recLabels = @json($recipesCategoryLabels ?? []);
                const recData = @json($recipesCategorySeries ?? []);
                const recColors = ['#10B981', '#059669', '#34D399', '#047857', '#6EE7B7', '#065F46', '#A7F3D0',
                    '#064E3B', '#D1FAE5', '#022C22'
                ];
                new Chart(ctxRecCat, {
                    type: 'doughnut',
                    data: {
                        labels: recLabels,
                        datasets: [{
                            data: recData,
                            backgroundColor: recColors.slice(0, recLabels.length),
                            borderWidth: 2,
                            borderColor: '#fff',
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${fmtBRL(ctx.parsed)}`
                                }
                            }
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 4.5 Orçamentos — resumo e utilização
            // ------------------------------------------------------------------
            const ctxBudSummary = document.getElementById('chartBudgetsSummary');
            if (ctxBudSummary) {
                const totalPlanned = parseFloat(@json($totalBudgetsPlanned ?? 0));
                const totalSpent = parseFloat(@json($totalBudgetsSpent ?? 0));
                if (totalPlanned <= 0) {
                    // nothing to show
                    ctxBudSummary.style.display = 'none';
                } else {
                    const remaining = Math.max(0, totalPlanned - totalSpent);
                    const over = Math.max(0, totalSpent - totalPlanned);

                    let labels, data, colors;
                    if (over > 0) {
                        labels = ['Planejado', 'Excedente'];
                        data = [totalPlanned, over];
                        colors = [hex2rgba(BLUE, 0.9), hex2rgba(RED, 0.9)];
                    } else {
                        labels = ['Gasto', 'Restante'];
                        data = [totalSpent, remaining];
                        colors = [hex2rgba(RED, 0.9), hex2rgba(BLUE, 0.9)];
                    }

                    new Chart(ctxBudSummary, {
                        type: 'doughnut',
                        data: {
                            labels,
                            datasets: [{
                                data,
                                backgroundColor: colors,
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '68%',
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        usePointStyle: true,
                                        boxWidth: 10
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => ` ${ctx.label}: ${fmtBRL(ctx.parsed)}`
                                    }
                                }
                            },
                        },
                    });
                }
            }

            const ctxBudProgress = document.getElementById('chartBudgetsProgress');
            if (ctxBudProgress) {
                const bLabels = @json($budgetLabels ?? []);
                const bPct = @json($budgetPercentSeries ?? []);
                const bPlan = @json($budgetPlannedSeries ?? []);
                const bSpent = @json($budgetSpentSeries ?? []);

                const barColors = bPct.map(p => p >= 90 ? RED : p >= 70 ? '#F97316' : GREEN);

                new Chart(ctxBudProgress, {
                    type: 'bar',
                    data: {
                        labels: bLabels,
                        datasets: [{
                            label: 'Utilização (%)',
                            data: bPct,
                            backgroundColor: barColors,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => {
                                        const i = ctx.dataIndex;
                                        const pct = ctx.parsed.x;
                                        const planned = bPlan[i] ?? 0;
                                        const spent = bSpent[i] ?? 0;
                                        return ` ${ctx.dataset.label}: ${pct}% — Planejado: ${fmtBRL(planned)} — Gasto: ${fmtBRL(spent)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: v => v + '%',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 5. Gastos diários do mês atual (Bar + Linha acumulada)
            // ------------------------------------------------------------------
            const ctxDaily = document.getElementById('chartDailyExpenses');
            if (ctxDaily) {
                const dailyLabels = @json($dailyLabels ?? []);
                const dailyData = @json($dailyData ?? []);
                const dailyCumul = @json($dailyCumulative ?? []);

                new Chart(ctxDaily, {
                    type: 'bar',
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                                label: 'Despesa do dia',
                                data: dailyData,
                                backgroundColor: hex2rgba(RED, 0.65),
                                borderColor: RED,
                                borderWidth: 1,
                                borderRadius: 3,
                                order: 2,
                            },
                            {
                                label: 'Acumulado',
                                data: dailyCumul,
                                type: 'line',
                                borderColor: BLUE,
                                backgroundColor: hex2rgba(BLUE, 0.08),
                                borderWidth: 2,
                                pointRadius: 0,
                                fill: true,
                                tension: 0.4,
                                order: 1,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ttBRL
                                }
                            },
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 10
                                    },
                                    maxTicksLimit: 15
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => 'R$ ' + v.toLocaleString('pt-BR'),
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 6. Tendência — Top 3 categorias de despesa (Line, 6 meses)
            // ------------------------------------------------------------------
            const ctxTrend = document.getElementById('chartCategoryTrend');
            if (ctxTrend) {
                const trendLabels = @json($trendLabels ?? []);
                const trendSeries = @json($trendSeries ?? []);
                const trendColors = [RED, '#F97316', '#B91C1C'];

                new Chart(ctxTrend, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: trendSeries.map((s, i) => ({
                            label: s.name,
                            data: s.data,
                            borderColor: trendColors[i] ?? COLORS[i],
                            backgroundColor: hex2rgba(trendColors[i] ?? COLORS[i], 0.08),
                            borderWidth: 2,
                            pointRadius: 4,
                            fill: false,
                            tension: 0.35,
                        })),
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ttBRL
                                }
                            },
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => 'R$ ' + v.toLocaleString('pt-BR'),
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 7. Cartões — Fatura vs Limite (valores absolutos)
            // ------------------------------------------------------------------
            const ctxCards = document.getElementById('chartCards');
            if (ctxCards) {
                const cards = @json(($creditCards ?? collect())->values());
                const labels = cards.map(c => c.name);
                const statements = cards.map(c => parseFloat(c.statement_amount) || 0);
                const limits = cards.map(c => parseFloat(c.limit) || 0);
                const cardColors = cards.map(c => (c.bank && c.bank.color) ? c.bank.color : (c.color || '#6B7280'));
                const cardColorsFaint = cardColors.map(col => hex2rgba(col, 0.25));
                new Chart(ctxCards, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Fatura',
                                data: statements,
                                backgroundColor: cardColors,
                                borderColor: cardColors,
                                borderWidth: 1,
                                borderRadius: 4
                            },
                            {
                                label: 'Limite',
                                data: limits,
                                backgroundColor: cardColorsFaint,
                                borderColor: cardColors,
                                borderWidth: 1,
                                borderRadius: 4
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ttBRL
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => 'R$ ' + v.toLocaleString('pt-BR'),
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                        },
                    },
                });
            }

            // ------------------------------------------------------------------
            // 8. Cartões — Utilização do limite (% barra horizontal)
            //    Verde < 70% · Laranja 70-89% · Vermelho ≥ 90%
            // ------------------------------------------------------------------
            const ctxUtil = document.getElementById('chartCardUtilization');
            if (ctxUtil) {
                const cards2 = @json(($creditCards ?? collect())->values());
                const labels2 = cards2.map(c => c.name);
                const pctData = cards2.map(c => {
                    const s = parseFloat(c.statement_amount) || 0;
                    const l = parseFloat(c.limit) || 0;
                    return l > 0 ? Math.min(100, Math.round((s / l) * 100)) : 0;
                });
                const utilColors = cards2.map((c, i) => {
                    const v = pctData[i];
                    if (v >= 90) return RED;
                    if (v >= 70) return '#F97316';
                    return (c.bank && c.bank.color) ? c.bank.color : (c.color || GREEN);
                });

                new Chart(ctxUtil, {
                    type: 'bar',
                    data: {
                        labels: labels2,
                        datasets: [{
                            label: 'Utilizado (%)',
                            data: pctData,
                            backgroundColor: utilColors,
                            borderRadius: 4
                        }],
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` Utilizado: ${ctx.parsed.x}%`
                                }
                            },
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: v => v + '%',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                },
                            },
                            y: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                        },
                    },
                });
            }

        });
    </script>
@endsection
