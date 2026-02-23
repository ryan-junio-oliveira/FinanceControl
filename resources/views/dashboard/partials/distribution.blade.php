@if (($creditCards ?? collect())->count() > 0)
    <x-dashboard-section title="Distribuição de Faturas" icon="chart-pie" color="orange">
        <div class="relative" style="height: 240px;">
            <canvas id="chartCardPie"></canvas>
        </div>
    </x-dashboard-section>
@endif
