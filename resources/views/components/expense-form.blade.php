@props([
    'model' => null,
    'categories' => [],
    'controls' => [],
    'creditCards' => [],
    'action',
    'method' => 'POST',
    'buttonLabel',
    'backUrl',
])

@php
    $nameVal = old('name', $model?->name ?? '');
    $amountVal = old('amount', $model?->amount ?? '');
    $dateVal = old('transaction_date', isset($model?->transaction_date) && $model->transaction_date ? $model->transaction_date->format('Y-m-d') : '');
    $categoryIdVal = old('category_id', $model?->category_id ?? '');
    $controlVal = old('monthly_financial_control_id', $model?->monthly_financial_control_id ?? '');
    $cardVal = old('credit_card_id', $model?->credit_card_id ?? '');
    $fixedVal = old('fixed', $model?->fixed ?? false);
    $paidVal = old('paid', $model?->paid ?? false);
    $paidAtVal = old('paid_at', isset($model?->paid_at) && $model->paid_at ? $model->paid_at->format('Y-m-d') : '');
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">

        <x-form-input name="name" label="{{ __('Nome') }}" :value="$nameVal" required placeholder="{{ __('Ex: Conta de luz, Mercado') }}" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="amount" label="{{ __('Valor (R$)') }}" type="number" step="0.01" :value="$amountVal" required placeholder="0,00" />
            <x-form-input name="transaction_date" label="{{ __('Data da transação') }}" type="date" :value="$dateVal" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Categoria') }} <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="" disabled>{{ __('Selecione uma categoria') }}</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected((string)$categoryIdVal === (string)$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Controle Mensal') }} <span class="text-xs text-gray-400">({{ __('opcional') }})</span></label>
                <select name="monthly_financial_control_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="">{{ __('Auto (criar/associar)') }}</option>
                    @foreach($controls as $c)
                        <option value="{{ $c->id }}" @selected((string)$controlVal === (string)$c->id)>{{ sprintf('%02d/%d', $c->month, $c->year) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Cartão') }} <span class="text-xs text-gray-400">({{ __('opcional') }})</span></label>
            <select name="credit_card_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="">{{ __('Nenhum') }}</option>
                @foreach($creditCards as $card)
                    <option value="{{ $card->id }}" @selected((string)$cardVal === (string)$card->id)>{{ $card->name }} — {{ $card->bank }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="fixed" :checked="$fixedVal" />
            <span class="text-sm font-medium text-gray-700">{{ __('Despesa fixa (recorrente)') }}</span>
        </label>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <label class="flex items-center gap-2 cursor-pointer">
                <x-form-checkbox name="paid" :checked="$paidVal" />
                <span class="text-sm font-medium text-gray-700">{{ __('Pago') }}</span>
            </label>
            <x-form-input name="paid_at" label="{{ __('Data de pagamento') }}" type="date" :value="$paidAtVal" />
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">{{ __('Cancelar') }}</x-link>
    </div>
</form>
