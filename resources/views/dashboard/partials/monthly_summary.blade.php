@php
    $hasMonthly = false;
    if (isset($monthlySeries) && is_array($monthlySeries)) {
        foreach ($monthlySeries as $s) {
            if (array_sum($s['data'] ?? []) > 0) {
                $hasMonthly = true;
                break;
            }
        }
    }
    if (!$hasMonthly && isset($cardsSeries)) {
        $hasMonthly = array_sum($cardsSeries) > 0;
    }
@endphp

@if ($hasMonthly)
    <x-dashboard-section title="Resumo financeiro" icon="chart-bar" color="blue">
        <div class="mb-6">
            <h4 class="text-base font-semibold text-gray-600 mb-2">Visão mensal (barras)</h4>
            <div class="relative" style="height: 300px;">
                <canvas id="chartFinanceBars"></canvas>
            </div>
        </div>

        <div>
            <h4 class="text-base font-semibold text-gray-600 mb-2">Tendência (linhas)</h4>
            <div class="relative" style="height: 260px;">
                <canvas id="chartFinanceLines"></canvas>
            </div>
        </div>
    </x-dashboard-section>
@endif
