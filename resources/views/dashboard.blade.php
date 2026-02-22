@extends('layouts.app')

@section('page_title', 'Dashboard Financeiro')

@section('content')
    <div class="space-y-6 p-4">

        <!-- HEADER -->
        <x-page-header title="Painel" subtitle="{{ now()->format('d/m/Y') }}" />

        <!-- KPIs agrupados -->
        <x-dashboard-section title="Visão Geral" icon="chart-line" color="emerald">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-kpi-card
                    title="Receitas"
                    :value="'R$ ' . number_format($totalRecipes ?? 0, 2, ',', '.')"
                    icon="arrow-trend-up"
                    color="emerald"
                    subtitle="Mês atual"
                />
                <x-kpi-card
                    title="Receitas fixas"
                    :value="'R$ ' . number_format($fixedRecipes ?? 0, 2, ',', '.')"
                    icon="lock"
                    color="emerald"
                    subtitle="Mês atual"
                />
                <x-kpi-card
                    title="Receitas variáveis"
                    :value="'R$ ' . number_format($variableRecipes ?? 0, 2, ',', '.')"
                    icon="random"
                    color="emerald"
                    subtitle="Mês atual"
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <x-kpi-card
                    title="Despesas"
                    :value="'R$ ' . number_format($totalExpenses ?? 0, 2, ',', '.')"
                    icon="arrow-trend-down"
                    color="red"
                    subtitle="Mês atual"
                />
                <x-kpi-card
                    title="Despesas fixas"
                    :value="'R$ ' . number_format($fixedExpenses ?? 0, 2, ',', '.')"
                    icon="lock"
                    color="red"
                    subtitle="Mês atual"
                />
                <x-kpi-card
                    title="Despesas variáveis"
                    :value="'R$ ' . number_format($variableExpenses ?? 0, 2, ',', '.')"
                    icon="random"
                    color="red"
                    subtitle="Mês atual"
                />
            </div>
        </x-dashboard-section>

        <x-dashboard-section title="Cartões / Investimentos" icon="credit-card" color="orange">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-kpi-card
                    title="Faturas"
                    :value="'R$ ' . number_format($cardsTotal ?? 0, 2, ',', '.')"
                    icon="credit-card"
                    color="orange"
                    subtitle="Mês atual"
                />

                <x-kpi-card
                    title="Despesas + faturas"
                    :value="'R$ ' . number_format(($totalExpenses ?? 0) + ($cardsTotal ?? 0), 2, ',', '.')"
                    icon="calculator"
                    color="orange"
                    subtitle="Mês atual"
                />

                <x-kpi-card
                    title="Investimentos"
                    :value="'R$ ' . number_format($totalInvestments ?? 0, 2, ',', '.')"
                    icon="piggy-bank"
                    color="cyan"
                    subtitle="Mês atual"
                />
            </div>
        </x-dashboard-section>

        <x-dashboard-section title="Saldos Financeiros" icon="scale-balanced" color="gray">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-kpi-card
                    title="Saldo (Receitas − Despesas)"
                    :value="'R$ ' . number_format(($totalRecipes ?? 0) - ($totalExpenses ?? 0), 2, ',', '.')"
                    icon="scale-balanced"
                    color="gray"
                    subtitle="Mês atual"
                />

                <x-kpi-card
                    title="Saldo (Receitas − (Despesas + Faturas))"
                    :value="'R$ ' . number_format(($totalRecipes ?? 0) - (($totalExpenses ?? 0) + ($cardsTotal ?? 0)), 2, ',', '.')"
                    icon="balance-scale-right"
                    color="gray"
                    subtitle="Mês atual"
                />
            </div>
        </x-dashboard-section>

        <!-- CHART: resumo financeiro em barras/linhas -->
        @php
            $hasMonthly = false;
            if (isset($monthlySeries) && is_array($monthlySeries)) {
                foreach ($monthlySeries as $s) {
                    if (array_sum($s['data'] ?? []) > 0) {
                        $hasMonthly = true;
                        break;
                    }
                }
            }
            if (!$hasMonthly && isset($cardsSeries)) {
                $hasMonthly = array_sum($cardsSeries) > 0;
            }
        @endphp
        @if ($hasMonthly)
            <x-dashboard-section title="Resumo financeiro" icon="chart-bar" color="blue">
                <div class="mb-6">
                    <h4 class="text-base font-semibold text-gray-600 mb-2">Visão mensal (barras)</h4>
                    <div class="relative" style="height: 300px;">
                        <canvas id="chartFinanceBars"></canvas>
                    </div>
                </div>

                <div>
                    <h4 class="text-base font-semibold text-gray-600 mb-2">Tendência (linhas)</h4>
                    <div class="relative" style="height: 260px;">
                        <canvas id="chartFinanceLines"></canvas>
                    </div>
                </div>
            </x-dashboard-section>
        @endif

        <!-- CHARTS: Categorias (doughnut) -->
        @if (count($expensesCategoryLabels ?? []) > 0 || count($recipesCategoryLabels ?? []) > 0)
            <x-dashboard-section title="Categorias" icon="chart-pie" color="teal">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Despesas por Categoria --}}
                    @if (count($expensesCategoryLabels ?? []) > 0)
                        <div>
                            <h4 class="text-base font-semibold text-gray-600 mb-2">Despesas</h4>
                            <div class="relative flex justify-center" style="height: 260px;">
                                <canvas id="chartExpensesCategory"></canvas>
                            </div>
                        </div>
                    @endif

                    {{-- Receitas por Categoria --}}
                    @if (count($recipesCategoryLabels ?? []) > 0)
                        <div>
                            <h4 class="text-base font-semibold text-gray-600 mb-2">Receitas</h4>
                            <div class="relative flex justify-center" style="height: 260px;">
                                <canvas id="chartRecipesCategory"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </x-dashboard-section>
        @endif

        <!-- BUDGET IMPACT -->
        @if (($availableBudgets ?? collect())->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ __('Orçamento') }}</h3>
                    @php
                        $budgetOptions = ($availableBudgets ?? collect())->map(function($b) {
                            $b->name = $b->name
                                . ' (' . \Carbon\Carbon::parse($b->start_date)->format('d/m')
                                . '–' . \Carbon\Carbon::parse($b->end_date)->format('d/m')
                                . ')';
                            return $b;
                        });
                    @endphp
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center">
                        <x-form-select
                            name="budget_id"
                            :options="$budgetOptions"
                            :value="request('budget_id')"
                            nullable-option="{{ __('(nenhum)') }}"
                            class="rounded-xl border border-gray-200 px-3 py-2 text-sm"
                            onchange="this.form.submit()"
                        />
                    </form>
                </div>

                @if ($selectedBudget)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-card label="{{ __('Planejado') }}" :value="$budgetImpact['planned']" icon="fa-chart-pie"
                            color="bg-emerald-500" />
                        <x-card label="{{ __('Gasto no período') }}" :value="$budgetImpact['spent']" icon="fa-wallet"
                            color="bg-red-500" />
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        {{ __('Utilização:') }} <strong>{{ $budgetImpact['percent'] }}%</strong>
                    </div>

                    {{-- comparison bar chart --}}
                    <div class="mt-6 bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Saldo atual vs previsto</h3>
                        <div class="relative" style="height:240px;">
                            <canvas id="chartBudgetComparison"></canvas>
                        </div>
                    </div>
                @else
                    <div class="text-sm text-gray-400">
                        {{ __('Selecione um orçamento para ver impacto nas despesas') }}
                    </div>
                @endif
            </div>
        @endif

        <!-- CHART: Gastos diários do mês atual -->
        @if (array_sum($dailyData ?? []) > 0)
            <x-dashboard-section title="Gastos Diários — {{ now()->format('F Y') }}" icon="calendar-days" color="cyan">
                <p class="text-xs text-gray-400 mb-4">Barras = valor do dia · Linha = acumulado</p>
                <div class="relative" style="height: 240px;">
                    <canvas id="chartDailyExpenses"></canvas>
                </div>
            </x-dashboard-section>
        @endif

        <!-- CHART: Tendência das top 3 categorias de despesa -->
        @if (count($trendSeries ?? []) > 0)
            <x-dashboard-section title="Tendência — Top 3 Categorias" icon="chart-line-up" color="purple">
                <p class="text-xs text-gray-400 mb-4">Evolução das maiores categorias nos últimos 6 meses</p>
                <div class="relative" style="height: 240px;">
                    <canvas id="chartCategoryTrend"></canvas>
                </div>
            </x-dashboard-section>
        @endif

        <!-- CHART: Cartões de Crédito — fatura e utilização -->
        @if (($creditCards ?? collect())->count() > 0)
            <x-dashboard-section title="Cartões">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-base font-semibold text-gray-600 mb-2">Faturas vs Limite</h4>
                        <div class="relative" style="height: 220px;">
                            <canvas id="chartCards"></canvas>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-base font-semibold text-gray-600 mb-2">Utilização do Limite</h4>
                        <p class="text-xs text-gray-400 mb-4">% do limite comprometido por cartão</p>
                        <div class="relative" style="height: 220px;">
                            <canvas id="chartCardUtilization"></canvas>
                        </div>
                    </div>
                </div>
            </x-dashboard-section>
        @endif

        <!-- CHART: Distribuição de faturas por cartão -->
        @if (($creditCards ?? collect())->count() > 0)
            <x-dashboard-section title="Distribuição de Faturas" icon="chart-pie" color="orange">
                <div class="relative" style="height: 240px;">
                    <canvas id="chartCardPie"></canvas>
                </div>
            </x-dashboard-section>
        @endif

        <!-- CHARTS: status pago/recebido -->
        @php
            // show each donut only if there's at least one real value
            $totalExpenses = $totalExpenses ?? 0;
            $totalRecipes = $totalRecipes ?? 0;
            $totalCards = $cardsTotal ?? 0;

            $hasExpensesData = $totalExpenses > 0;
            $hasRecipesData = $totalRecipes > 0;
            $hasCardsData = $totalCards > 0;

            // overall container shown when any dataset has values
            $hasAnyPaid = $hasExpensesData || $hasRecipesData || $hasCardsData;
        @endphp

        @if ($hasAnyPaid)
            <x-dashboard-section title="Status de Pagamento" icon="circle-check" color="green">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if ($hasExpensesData)
                        <div>
                            <h4 class="text-base font-semibold text-gray-600 mb-2">Despesas</h4>
                            <div class="relative flex justify-center" style="height: 240px;">
                                <canvas id="chartExpensesPaid"></canvas>
                            </div>
                        </div>
                    @endif
                    @if ($hasRecipesData)
                        <div>
                            <h4 class="text-base font-semibold text-gray-600 mb-2">Receitas</h4>
                            <div class="relative flex justify-center" style="height: 240px;">
                                <canvas id="chartRecipesReceived"></canvas>
                            </div>
                        </div>
                    @endif
                    @if ($hasCardsData)
                        <div>
                            <h4 class="text-base font-semibold text-gray-600 mb-2">Faturas</h4>
                            <div class="relative flex justify-center" style="height: 240px;">
                                <canvas id="chartCardsPaid"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </x-dashboard-section>
        @endif

        <!-- Transações Recentes -->
        @if (isset($recentTransactions) && $recentTransactions->count())
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Últimas Transações</h3>
                <x-table :columns="[
                    ['label' => 'Tipo'],
                    ['label' => 'Descrição'],
                    ['label' => 'Data'],
                    ['label' => 'Valor', 'class' => 'text-right'],
                ]" class="text-gray-600">
                    @foreach ($recentTransactions as $tx)
                        <tr
                            class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($tx['type'] === 'income')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Receita
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Despesa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $tx['type'] === 'income' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }} text-sm font-semibold">
                                        {{ strtoupper(mb_substr($tx['name'], 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-heading">{{ $tx['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-gray-400 text-xs"></i>
                                    {{ \Carbon\Carbon::parse($tx['date'])->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span
                                    class="text-sm font-semibold tabular-nums {{ $tx['type'] === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $tx['type'] === 'income' ? '+' : '−' }} R$
                                    {{ number_format($tx['amount'], 2, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
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
            const ORANGE = '#F97316';

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
            // 1a. Barra: receitas, despesas, faturas por mês
            // ------------------------------------------------------------------
            const ctxBars = document.getElementById('chartFinanceBars');
            if (ctxBars) {
                const labels = @json($monthlyCategories ?? []);
                const monthlySeries = @json($monthlySeries ?? []);
                const incomes = monthlySeries.find(s => s.name === 'Receitas')?.data ?? [];
                const expenses = monthlySeries.find(s => s.name === 'Despesas')?.data ?? [];
                const cards = @json($cardsSeries ?? []);

                new Chart(ctxBars, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Receitas',
                                data: incomes,
                                backgroundColor: hex2rgba(GREEN, 0.75),
                                borderColor: GREEN,
                                borderWidth: 1,
                                borderRadius: 3
                            },
                            {
                                label: 'Despesas',
                                data: expenses,
                                backgroundColor: hex2rgba(RED, 0.75),
                                borderColor: RED,
                                borderWidth: 1,
                                borderRadius: 3
                            },
                            {
                                label: 'Faturas',
                                data: cards,
                                backgroundColor: hex2rgba(ORANGE, 0.75),
                                borderColor: ORANGE,
                                borderWidth: 1,
                                borderRadius: 3
                            }
                        ]
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
                            }
                        }
                    }
                });
            }

            // ------------------------------------------------------------------
            // 1b. Linha: receitas, despesas, faturas, saldo
            // ------------------------------------------------------------------
            const ctxLines = document.getElementById('chartFinanceLines');
            if (ctxLines) {
                const labels = @json($monthlyCategories ?? []);
                const monthlySeries = @json($monthlySeries ?? []);
                const cards = @json($cardsSeries ?? []);
                const incomes = monthlySeries.find(s => s.name === 'Receitas')?.data ?? [];
                const expenses = monthlySeries.find(s => s.name === 'Despesas')?.data ?? [];
                const saldo = incomes.map((v, i) => v - ((expenses[i] || 0) + (cards[i] || 0)));

                new Chart(ctxLines, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Receitas',
                                data: incomes,
                                borderColor: GREEN,
                                backgroundColor: hex2rgba(GREEN, 0.1),
                                tension: 0.3
                            },
                            {
                                label: 'Despesas',
                                data: expenses,
                                borderColor: RED,
                                backgroundColor: hex2rgba(RED, 0.1),
                                tension: 0.3
                            },
                            {
                                label: 'Faturas',
                                data: cards,
                                borderColor: ORANGE,
                                backgroundColor: hex2rgba(ORANGE, 0.1),
                                tension: 0.3
                            },
                            {
                                label: 'Saldo',
                                data: saldo,
                                borderColor: BLUE,
                                backgroundColor: hex2rgba(BLUE, 0.1),
                                tension: 0.3
                            }
                        ]
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
                            }
                        }
                    }
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

            // ------------------------------------------------------------------
            // 9. Pie: distribuição de faturas por cartão
            // ------------------------------------------------------------------
            const ctxPie = document.getElementById('chartCardPie');
            if (ctxPie) {
                const cards3 = @json(($creditCards ?? collect())->values());
                const labels3 = cards3.map(c => c.name);
                const data3 = cards3.map(c => parseFloat(c.statement_amount) || 0);
                const colors3 = cards3.map(c => (c.bank && c.bank.color) ? c.bank.color : (c.color || '#6B7280'));
                console.log('pie cards', labels3, data3, colors3);
                new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: labels3,
                        datasets: [{
                            data: data3,
                            backgroundColor: colors3,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
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
                        }
                    }
                });
            }

            // ------------------------------------------------------------------
            // 9b. Paid/received breakdowns
            // ------------------------------------------------------------------
            const ctxExpPaid = document.getElementById('chartExpensesPaid');
            if (ctxExpPaid) {
                const paid = {{ $totalExpensesPaid ?? 0 }};
                const unpaid = {{ ($totalExpenses ?? 0) - ($totalExpensesPaid ?? 0) }};

                if (paid + unpaid > 0) {
                    new Chart(ctxExpPaid, {
                        type: 'doughnut',
                        data: {
                            labels: ['Pagas', 'Não pagas'],
                            datasets: [{
                                data: [paid, unpaid],
                                backgroundColor: [GREEN, RED],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                            }
                        }
                    });
                }
            }

            const ctxRecPaid = document.getElementById('chartRecipesReceived');
            if (ctxRecPaid) {
                const rec = {{ $totalRecipesReceived ?? 0 }};
                const recPend = {{ ($totalRecipes ?? 0) - ($totalRecipesReceived ?? 0) }};

                if (rec + recPend > 0) {
                    new Chart(ctxRecPaid, {
                        type: 'doughnut',
                        data: {
                            labels: ['Recebidas', 'Não recebidas'],
                            datasets: [{
                                data: [rec, recPend],
                                backgroundColor: [GREEN, RED],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                            }
                        }
                    });
                }
            }

            const ctxCardsPaid = document.getElementById('chartCardsPaid');
            if (ctxCardsPaid) {
                const cp = {{ $cardsPaid ?? 0 }};
                const cup = {{ ($cardsTotal ?? 0) - ($cardsPaid ?? 0) }};

                if (cp + cup > 0) {
                    new Chart(ctxCardsPaid, {
                        type: 'doughnut',
                        data: {
                            labels: ['Pagas', 'Não pagas'],
                            datasets: [{
                                data: [cp, cup],
                                backgroundColor: [GREEN, RED],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
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
                            }
                        }
                    });
                }
            }

            // ------------------------------------------------------------------
            // 10. Budget comparison bar
            // ------------------------------------------------------------------
            const ctxBudComp = document.getElementById('chartBudgetComparison');
            if (ctxBudComp) {
                const comp = @json($budgetComparison ?? null);
                if (comp) {
                    new Chart(ctxBudComp, {
                        type: 'bar',
                        data: {
                            labels: ['Atual', 'Previsto'],
                            datasets: [{
                                data: [comp.actual, comp.predicted],
                                backgroundColor: [BLUE, ORANGE]
                            }]
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
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }

        });
    </script>
@endsection
