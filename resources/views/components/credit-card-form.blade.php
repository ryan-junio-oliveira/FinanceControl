@props([
    'model' => null,
    'banks' => [],
    'action',
    'method' => 'POST',
    'buttonLabel',
    'backUrl',
])

@php
    $nameVal = old('name', $model?->name() ?? '');
    $bankIdVal = old('bank_id', $model?->bankId() ?? '');
    $statementVal = old('statement_amount', $model?->statementAmount() ?? '');
    $limitVal = old('limit', $model?->limit() ?? '');
    $closingVal = old('closing_day', $model?->closingDay() ?? '');
    $dueVal = old('due_day', $model?->dueDay() ?? '');
    $activeVal = old('is_active', $model?->isActive() ?? true);
    $colorVal  = old('color', $model?->color() ?? null);
    $paidVal   = old('paid', $model?->paid() ?? false);
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="{{ __('Nome do cartão') }}" :value="$nameVal" required placeholder="{{ __('Ex: Nubank, Inter, Bradesco') }}" />

        <div>
            <x-form-select
                name="bank_id"
                label="{{ __('Banco') }}"
                :options="$banks"
                :value="$bankIdVal"
                placeholder="{{ __('Selecione um banco') }}"
                required
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="statement_amount" label="{{ __('Valor da fatura (R$)') }}" type="number" step="0.01" :value="$statementVal" required placeholder="0,00" />
            <x-form-input name="limit" label="{{ __('Limite (opcional)') }}" type="number" step="0.01" :value="$limitVal" placeholder="0,00" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="closing_day" label="{{ __('Dia de fechamento (1-31)') }}" type="number" min="1" max="31" :value="$closingVal" placeholder="{{ __('Ex: 28') }}" />
            <x-form-input name="due_day" label="{{ __('Dia de vencimento (1-31)') }}" type="number" min="1" max="31" :value="$dueVal" placeholder="{{ __('Ex: 5') }}" />
        </div>

        <div class="flex items-center gap-6">
            <x-form-checkbox name="is_active" :checked="$activeVal" label="{{ __('Cartão ativo') }}" class="cursor-pointer" />
            <x-form-checkbox name="paid" :checked="$paidVal" label="{{ __('Fatura paga') }}" class="cursor-pointer" />

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Cor') }} <span class="text-xs text-gray-400">({{ __('opcional') }})</span></label>
                <div class="flex items-center gap-2">
                    <input type="color" value="{{ $colorVal ?? '#005E7D' }}"
                        oninput="document.getElementById('card_color_text').value = this.value"
                        class="h-9 w-10 cursor-pointer rounded-lg border border-gray-200 p-1" />
                    <x-form-input name="color" id="card_color_text" :value="$colorVal" placeholder="#RRGGBB" class="flex-1" />
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">{{ __('Cancelar') }}</x-link>
    </div>
</form>
