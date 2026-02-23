@if (count($trendSeries ?? []) > 0)
    <x-dashboard-section title="Tendência — Top 3 Categorias" icon="chart-line-up" color="purple">
        <p class="text-xs text-gray-400 mb-4">Evolução das maiores categorias nos últimos 6 meses</p>
        <div class="relative" style="height: 240px;">
            <canvas id="chartCategoryTrend"></canvas>
        </div>
    </x-dashboard-section>
@endif
