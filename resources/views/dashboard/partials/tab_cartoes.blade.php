{{-- Tab: Cartões --}}

{{-- KPIs --}}
<x-dashboard-section title="Cartões de Crédito" icon="credit-card" color="orange">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-kpi-card
            title="Total Faturas"
            :value="'R$ ' . number_format($cardsTotal ?? 0, 2, ',', '.')"
            icon="credit-card"
            color="orange"
            subtitle="Mês atual"
        />
        <x-kpi-card
            title="Despesas + Faturas"
            :value="'R$ ' . number_format(($totalExpenses ?? 0) + ($cardsTotal ?? 0), 2, ',', '.')"
            icon="calculator"
            color="orange"
            subtitle="Mês atual"
        />
        <x-kpi-card
            title="Saldo (c/ faturas)"
            :value="'R$ ' . number_format(($totalRecipes ?? 0) - (($totalExpenses ?? 0) + ($cardsTotal ?? 0)), 2, ',', '.')"
            icon="scale-balanced"
            color="gray"
            subtitle="Mês atual"
        />
    </div>
</x-dashboard-section>

@include('dashboard.partials.cards_charts')
@include('dashboard.partials.distribution')

{{-- Status Faturas --}}
@if (($cardsTotal ?? 0) > 0)
    <x-dashboard-section title="Status das Faturas" icon="circle-check" color="orange">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="relative flex justify-center" style="height: 240px;">
                <canvas id="chartCardsPaid"></canvas>
            </div>
            <div class="space-y-3 text-sm">
                @php
                    $cp  = $cardsPaid ?? 0;
                    $cup = ($cardsTotal ?? 0) - $cp;
                @endphp
                <div class="flex justify-between">
                    <span class="text-emerald-600 font-medium">Pagas</span>
                    <span>R$ {{ number_format($cp, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-red-500 font-medium">Pendentes</span>
                    <span>R$ {{ number_format($cup, 2, ',', '.') }}</span>
                </div>
                @if (($cardsTotal ?? 0) > 0)
                    <div class="pt-2 border-t border-gray-100 flex justify-between">
                        <span class="text-gray-500">% pago</span>
                        <span class="font-semibold">{{ round(($cp / ($cardsTotal ?? 1)) * 100, 1) }}%</span>
                    </div>
                @endif
            </div>
        </div>
    </x-dashboard-section>
@endif
