@if (($availableBudgets ?? collect())->count() > 0)
    <div class="bg-white rounded-xl shadow-md p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">{{ __('Orçamento') }}</h3>
            @php
                $budgetOptions = ($availableBudgets ?? collect())->map(function($b) {
                    $b->name = $b->name
                        /* Lines omitted */
                        . ')';
                    return $b;
                });
            @endphp
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center">
                <x-form-select
                    name="budget_id"
                    :options="$budgetOptions"
                    :value="request('budget_id')"
                    nullable-option="{{ __('(nenhum)') }}"
                    class="rounded-xl border border-gray-200 px-3 py-2 text-sm"
                    onchange="this.form.submit()"
                />
            </form>
        </div>

        @if ($selectedBudget)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card label="{{ __('Planejado') }}" :value="$budgetImpact['planned']" icon="fa-chart-pie"
                    color="bg-emerald-500" />
                <x-card label="{{ __('Gasto no período') }}" :value="$budgetImpact['spent']" icon="fa-wallet"
                    color="bg-red-500" />
            </div>
            <div class="mt-4 text-sm text-gray-500">
                {{ __('Utilização:') }} <strong>{{ $budgetImpact['percent'] }}%</strong>
            </div>

            {{-- comparison bar chart --}}
            <div class="mt-6 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Saldo atual vs previsto</h3>
                <div class="relative" style="height:240px;">
                    <canvas id="chartBudgetComparison"></canvas>
                </div>
            </div>
        @else
            <div class="text-sm text-gray-400">
                {{ __('Selecione um orçamento para ver impacto nas despesas') }}
            </div>
        @endif
    </div>
@endif
