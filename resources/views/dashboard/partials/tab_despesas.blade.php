{{-- Tab: Despesas --}}

{{-- KPIs --}}
<x-dashboard-section title="Despesas" icon="arrow-trend-down" color="red">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-kpi-card
            title="Total Despesas"
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

{{-- Despesas por Categoria --}}
@if (count($expensesCategoryLabels ?? []) > 0)
    <x-dashboard-section title="Categorias de Despesas" icon="chart-pie" color="red">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="relative flex justify-center" style="height: 280px;">
                <canvas id="chartExpensesCategory"></canvas>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-600 mb-3">Distribuição por categoria</h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    @php
                        $expTotal = array_sum($expensesCategorySeries ?? []);
                    @endphp
                    @foreach (($expensesCategoryLabels ?? []) as $i => $label)
                        @php
                            $val = ($expensesCategorySeries ?? [])[$i] ?? 0;
                            $pct = $expTotal > 0 ? round(($val / $expTotal) * 100, 1) : 0;
                        @endphp
                        <li class="flex justify-between">
                            <span>{{ $label }}</span>
                            <span class="font-medium">R$ {{ number_format($val, 2, ',', '.') }} ({{ $pct }}%)</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-dashboard-section>
@endif

{{-- Status Pagamento Despesas --}}
@if (($totalExpenses ?? 0) > 0)
    <x-dashboard-section title="Status de Pagamento" icon="circle-check" color="red">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="relative flex justify-center" style="height: 240px;">
                <canvas id="chartExpensesPaid"></canvas>
            </div>
            <div class="space-y-3 text-sm">
                @php
                    $expPaid    = $totalExpensesPaid ?? 0;
                    $expUnpaid  = ($totalExpenses ?? 0) - $expPaid;
                @endphp
                <div class="flex justify-between">
                    <span class="text-emerald-600 font-medium">Pagas</span>
                    <span>R$ {{ number_format($expPaid, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-red-500 font-medium">Pendentes</span>
                    <span>R$ {{ number_format($expUnpaid, 2, ',', '.') }}</span>
                </div>
                @if (($totalExpenses ?? 0) > 0)
                    <div class="pt-2 border-t border-gray-100 flex justify-between">
                        <span class="text-gray-500">% pago</span>
                        <span class="font-semibold">{{ round(($expPaid / ($totalExpenses ?? 1)) * 100, 1) }}%</span>
                    </div>
                @endif
            </div>
        </div>
    </x-dashboard-section>
@endif

@include('dashboard.partials.daily_expenses')
@include('dashboard.partials.trend_top3')
@include('dashboard.partials.budget_impact')
