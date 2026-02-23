@extends('layouts.app')

@section('page_title', 'Dashboard Financeiro')

@section('content')
    <div class="space-y-6 p-4">

        <!-- HEADER -->
        <x-page-header title="Painel" subtitle="{{ now()->format('d/m/Y') }}" />

        {{-- ── Tab Navigation ── --}}
        @php
            $tabs = [
                ['id' => 'geral',         'label' => 'Geral',         'icon' => 'chart-line'],
                ['id' => 'receitas',      'label' => 'Receitas',      'icon' => 'arrow-trend-up'],
                ['id' => 'despesas',      'label' => 'Despesas',      'icon' => 'arrow-trend-down'],
                ['id' => 'cartoes',       'label' => 'Cartões',       'icon' => 'credit-card'],
                ['id' => 'investimentos', 'label' => 'Investimentos', 'icon' => 'piggy-bank'],
                ['id' => 'transacoes',    'label' => 'Transações',    'icon' => 'list'],
            ];
        @endphp

        <div x-data="{ activeTab: 'geral' }">

            {{-- Tab bar --}}
            <div class="flex flex-wrap gap-1 border-b border-gray-200 mb-6 overflow-x-auto">
                @foreach ($tabs as $tab)
                    <button
                        @click="activeTab = '{{ $tab['id'] }}'; setTimeout(() => window.dispatchEvent(new Event('resize')), 50)"
                        :class="activeTab === '{{ $tab['id'] }}'
                            ? 'border-b-2 border-blue-600 text-blue-700 bg-blue-50'
                            : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'"
                        class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-t-md transition-colors whitespace-nowrap focus:outline-none"
                    >
                        <x-fa-icon name="{{ $tab['icon'] }}" class="h-4 w-4" />
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Tab panels --}}
            <div x-show="activeTab === 'geral'" class="space-y-6">
                @include('dashboard.partials.tab_geral')
            </div>

            <div x-show="activeTab === 'receitas'" class="space-y-6" x-cloak>
                @include('dashboard.partials.tab_receitas')
            </div>

            <div x-show="activeTab === 'despesas'" class="space-y-6" x-cloak>
                @include('dashboard.partials.tab_despesas')
            </div>

            <div x-show="activeTab === 'cartoes'" class="space-y-6" x-cloak>
                @include('dashboard.partials.tab_cartoes')
            </div>

            <div x-show="activeTab === 'investimentos'" class="space-y-6" x-cloak>
                @include('dashboard.partials.tab_investimentos')
            </div>

            <div x-show="activeTab === 'transacoes'" class="space-y-6" x-cloak>
                @include('dashboard.partials.tab_transacoes')
            </div>

        </div>
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

            // investment-specific color list reused by multiple charts
            const invColors = ['#10B981', '#3B82F6', '#F97316', '#8B5CF6', '#EC4899', '#EAB308'];

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
                const investments = monthlySeries.find(s => s.name === 'Investimentos')?.data ?? [];
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
                            },
                            {
                                label: 'Investimentos',
                                data: investments,
                                backgroundColor: hex2rgba('#06B6D4', 0.75),
                                borderColor: '#06B6D4',
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
                const investments = monthlySeries.find(s => s.name === 'Investimentos')?.data ?? [];
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
                                label: 'Investimentos',
                                data: investments,
                                borderColor: '#06B6D4',
                                backgroundColor: hex2rgba('#06B6D4', 0.1),
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
            // 3b. Investimentos por categoria — Doughnut
            // ------------------------------------------------------------------
            const ctxInvCatDash = document.getElementById('chartInvestmentsCategory');
            if (ctxInvCatDash) {
                const invLabels = @json($investmentsCategoryLabels ?? []);
                const invData = @json($investmentsCategorySeries ?? []);

                new Chart(ctxInvCatDash, {
                    type: 'doughnut',
                    data: {
                        labels: invLabels,
                        datasets: [{
                            data: invData,
                            backgroundColor: invColors.slice(0, invLabels.length),
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
            // investment category bar (current month)
            // ------------------------------------------------------------------
            const ctxInvBar = document.getElementById('chartInvestmentsCatBar');
            if (ctxInvBar) {
                const invLabels2 = @json($investmentsCategoryLabels ?? []);
                const invData2 = @json($investmentsCategorySeries ?? []);
                new Chart(ctxInvBar, {
                    type: 'bar',
                    data: {
                        labels: invLabels2,
                        datasets: [{
                            label: 'Valor',
                            data: invData2,
                            backgroundColor: invColors.slice(0, invLabels2.length),
                            borderColor: invColors.slice(0, invLabels2.length),
                            borderWidth:1,
                            borderRadius:3
                        }]
                    },
                    options: {
                        responsive:true,
                        maintainAspectRatio:false,
                        interaction:{mode:'index',intersect:false},
                        plugins:{legend:{display:false},tooltip:{callbacks:{label:ttBRL}}},
                        scales:{x:{grid:{display:false},ticks:{font:{size:11}}},y:{beginAtZero:true,ticks:{callback:v=>'R$ '+v.toLocaleString('pt-BR'),font:{size:11}},grid:{color:'rgba(0,0,0,0.05)'}}}
                    }
                });
            }

            // ------------------------------------------------------------------
            // investment categories trend (line)
            // ------------------------------------------------------------------
            const ctxInvLine = document.getElementById('chartInvestmentsCatLine');
            if (ctxInvLine) {
                const trendLabels = @json($monthlyCategories ?? []);
                const trendSeries = @json($investmentsTrendSeries ?? []);
                new Chart(ctxInvLine, {
                    type: 'line',
                    data: {
                        labels: trendLabels,
                        datasets: trendSeries.map((s,i)=>({
                            label: s.name,
                            data: s.data,
                            borderColor: invColors[i] ?? COLORS[i],
                            backgroundColor: hex2rgba(invColors[i] ?? COLORS[i],0.08),
                            borderWidth:2,
                            pointRadius:4,
                            fill:false,
                            tension:0.35
                        }))
                    },
                    options: {
                        responsive:true,
                        maintainAspectRatio:false,
                        interaction:{mode:'index',intersect:false},
                        plugins:{legend:{position:'top',labels:{usePointStyle:true,boxWidth:10}},tooltip:{callbacks:{label:ttBRL}}},
                        scales:{x:{grid:{display:false},ticks:{font:{size:11}}},y:{beginAtZero:true,ticks:{callback:v=>'R$ '+v.toLocaleString('pt-BR'),font:{size:11}},grid:{color:'rgba(0,0,0,0.05)'}}}
                    }
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
