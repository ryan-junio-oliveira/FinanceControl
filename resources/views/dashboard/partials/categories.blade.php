@if (count($expensesCategoryLabels ?? []) > 0 || count($recipesCategoryLabels ?? []) > 0 || count($investmentsCategoryLabels ?? []) > 0)
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

            {{-- Investimentos por Categoria --}}
            @php
                $hasInvPizza = array_sum($investmentsCategorySeries ?? []) > 0;
                $hasInvBar = $hasInvPizza;
                $hasInvLine = count($investmentsTrendSeries ?? []) > 0 &&
                              array_sum(collect($investmentsTrendSeries)->pluck('data')->flatten()->toArray()) > 0;
            @endphp

            @if ($hasInvPizza)
                <div>
                    <h4 class="text-base font-semibold text-gray-600 mb-2">Investimentos (pizza)</h4>
                    <div class="relative flex justify-center" style="height: 260px;">
                        <canvas id="chartInvestmentsCategory"></canvas>
                    </div>
                </div>
            @endif
        </div>

        {{-- additional investment charts --}}
        @if ($hasInvBar || $hasInvLine)
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($hasInvBar)
                <div class="relative" style="height:260px;">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Investimentos por categoria (barra)</h4>
                    <canvas id="chartInvestmentsCatBar"></canvas>
                </div>
                @endif

                @if ($hasInvLine)
                <div class="relative" style="height:260px;">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Tendência por categoria</h4>
                    <canvas id="chartInvestmentsCatLine"></canvas>
                </div>
                @endif
            </div>
        @endif
        </div>
    </x-dashboard-section>
@endif
