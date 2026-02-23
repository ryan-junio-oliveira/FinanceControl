{{-- Tab: Investimentos --}}

{{-- KPI --}}
<x-dashboard-section title="Investimentos" icon="piggy-bank" color="cyan">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-kpi-card
            title="Total Investimentos"
            :value="'R$ ' . number_format($totalInvestments ?? 0, 2, ',', '.')"
            icon="piggy-bank"
            color="cyan"
            subtitle="Mês atual"
        />
        <x-kpi-card
            title="% da Receita"
            :value="(($totalRecipes ?? 0) > 0 ? number_format(($totalInvestments ?? 0) / ($totalRecipes ?? 1) * 100, 1, ',', '.') : '0,0') . '%'"
            icon="percent"
            color="cyan"
            subtitle="Sobre receita do mês"
        />
        <x-kpi-card
            title="Saldo pós-investimento"
            :value="'R$ ' . number_format(($totalRecipes ?? 0) - ($totalExpenses ?? 0) - ($cardsTotal ?? 0) - ($totalInvestments ?? 0), 2, ',', '.')"
            icon="scale-balanced"
            color="gray"
            subtitle="Mês atual"
        />
    </div>
</x-dashboard-section>

{{-- Investimentos por Categoria --}}
@php
    $hasInvPizza = array_sum($investmentsCategorySeries ?? []) > 0;
    $hasInvLine  = count($investmentsTrendSeries ?? []) > 0 &&
                   array_sum(collect($investmentsTrendSeries)->pluck('data')->flatten()->toArray()) > 0;
@endphp

@if ($hasInvPizza)
    <x-dashboard-section title="Categorias de Investimentos" icon="chart-pie" color="cyan">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            {{-- Doughnut --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-600 mb-2">Distribuição (pizza)</h4>
                <div class="relative flex justify-center" style="height: 280px;">
                    <canvas id="chartInvestmentsCategory"></canvas>
                </div>
            </div>
            {{-- Bar --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-600 mb-2">Por categoria (barra)</h4>
                <div class="relative" style="height: 280px;">
                    <canvas id="chartInvestmentsCatBar"></canvas>
                </div>
            </div>
        </div>

        @if ($hasInvLine)
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-600 mb-2">Tendência por categoria</h4>
                <div class="relative" style="height: 260px;">
                    <canvas id="chartInvestmentsCatLine"></canvas>
                </div>
            </div>
        @endif
    </x-dashboard-section>
@else
    <div class="flex items-center justify-center h-28 text-gray-400 text-sm">
        Nenhum investimento registrado neste mês.
    </div>
@endif
