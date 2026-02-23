{{-- Tab: Receitas --}}

{{-- KPIs --}}
<x-dashboard-section title="Receitas" icon="arrow-trend-up" color="emerald">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-kpi-card
            title="Total Receitas"
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
</x-dashboard-section>

{{-- Receitas por Categoria --}}
@if (count($recipesCategoryLabels ?? []) > 0)
    <x-dashboard-section title="Categorias de Receitas" icon="chart-pie" color="emerald">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="relative flex justify-center" style="height: 280px;">
                <canvas id="chartRecipesCategory"></canvas>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-600 mb-3">Distribuição por categoria</h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    @php
                        $recTotal = array_sum($recipesCategorySeries ?? []);
                    @endphp
                    @foreach (($recipesCategoryLabels ?? []) as $i => $label)
                        @php
                            $val = ($recipesCategorySeries ?? [])[$i] ?? 0;
                            $pct = $recTotal > 0 ? round(($val / $recTotal) * 100, 1) : 0;
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

{{-- Status Receitas --}}
@if (($totalRecipes ?? 0) > 0)
    <x-dashboard-section title="Status de Recebimento" icon="circle-check" color="emerald">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="relative flex justify-center" style="height: 240px;">
                <canvas id="chartRecipesReceived"></canvas>
            </div>
            <div class="space-y-3 text-sm">
                @php
                    $recReceived = $totalRecipesReceived ?? 0;
                    $recPending  = ($totalRecipes ?? 0) - $recReceived;
                @endphp
                <div class="flex justify-between">
                    <span class="text-emerald-600 font-medium">Recebidas</span>
                    <span>R$ {{ number_format($recReceived, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-red-500 font-medium">Pendentes</span>
                    <span>R$ {{ number_format($recPending, 2, ',', '.') }}</span>
                </div>
                @if (($totalRecipes ?? 0) > 0)
                    <div class="pt-2 border-t border-gray-100 flex justify-between">
                        <span class="text-gray-500">% recebido</span>
                        <span class="font-semibold">{{ round(($recReceived / ($totalRecipes ?? 1)) * 100, 1) }}%</span>
                    </div>
                @endif
            </div>
        </div>
    </x-dashboard-section>
@endif
