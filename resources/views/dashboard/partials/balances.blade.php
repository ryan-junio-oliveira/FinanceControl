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
