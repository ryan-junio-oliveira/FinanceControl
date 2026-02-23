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
