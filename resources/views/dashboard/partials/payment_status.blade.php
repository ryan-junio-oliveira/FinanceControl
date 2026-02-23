@php
    $totalExpenses = $totalExpenses ?? 0;
    $totalRecipes = $totalRecipes ?? 0;
    $totalCards = $cardsTotal ?? 0;

    $hasExpensesData = $totalExpenses > 0;
    $hasRecipesData = $totalRecipes > 0;
    $hasCardsData = $totalCards > 0;

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
