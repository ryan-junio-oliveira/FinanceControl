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
