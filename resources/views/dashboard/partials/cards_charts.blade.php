@if (($creditCards ?? collect())->count() > 0)
    <x-dashboard-section title="Cartões">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-base font-semibold text-gray-600 mb-2">Faturas vs Limite</h4>
                <div class="relative" style="height: 220px;">
                    <canvas id="chartCards"></canvas>
                </div>
            </div>
            <div>
                <h4 class="text-base font-semibold text-gray-600 mb-2">Utilização do Limite</h4>
                <p class="text-xs text-gray-400 mb-4">% do limite comprometido por cartão</p>
                <div class="relative" style="height: 220px;">
                    <canvas id="chartCardUtilization"></canvas>
                </div>
            </div>
        </div>
    </x-dashboard-section>
@endif
