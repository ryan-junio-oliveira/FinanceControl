@if (array_sum($dailyData ?? []) > 0)
    <x-dashboard-section title="Gastos Diários — {{ now()->format('F Y') }}" icon="calendar-days" color="cyan">
        <p class="text-xs text-gray-400 mb-4">Barras = valor do dia · Linha = acumulado</p>
        <div class="relative" style="height: 240px;">
            <canvas id="chartDailyExpenses"></canvas>
        </div>
    </x-dashboard-section>
@endif
