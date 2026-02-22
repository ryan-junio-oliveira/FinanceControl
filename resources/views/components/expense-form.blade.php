@props([
    'model' => null,
    'categories' => [],
    'creditCards' => [],
    'action',
    'method' => 'POST',
    'buttonLabel',
    'backUrl',
])

@php
    $nameVal = old('name', $model?->name ?? '');
    $amountVal = old('amount', $model?->amount ?? '');
    $dateVal = old(
        'transaction_date',
        isset($model?->transaction_date) && $model->transaction_date ? $model->transaction_date->format('Y-m-d') : '',
    );
    $categoryIdVal = old('category_id', $model?->category_id ?? '');
    $cardVal = old('credit_card_id', $model?->credit_card_id ?? '');
    $fixedVal = old('fixed', $model?->fixed ?? false);
    $paidVal = old('paid', $model?->paid ?? false);
    $paidAtVal = '';
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">

        <x-form-input name="name" label="{{ __('Nome') }}" :value="$nameVal" required
            placeholder="{{ __('Ex: Conta de luz, Mercado') }}" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="amount" label="{{ __('Valor (R$)') }}" type="number" step="0.01" :value="$amountVal"
                required placeholder="0,00" />
            <x-form-input name="transaction_date" label="{{ __('Data da transação') }}" type="date"
                :value="$dateVal" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <x-form-select
                    name="category_id"
                    label="{{ __('Categoria') }}"
                    :options="$categories"
                    :value="$categoryIdVal"
                    placeholder="{{ __('Selecione uma categoria') }}"
                    required
                />
            </div>

            <div>
                <x-form-select
                    name="credit_card_id"
                    label="{{ __('Cartão') }}"
                    :options="$creditCards"
                    :value="$cardVal"
                    nullable-option="{{ __('Nenhum') }}"
                />
            </div>
        </div>

        <x-form-checkbox name="fixed" :checked="$fixedVal" label="{{ __('Despesa fixa (recorrente)') }}"
            class="cursor-pointer" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-checkbox name="paid" :checked="$paidVal" label="{{ __('Pago') }}" class="cursor-pointer" />
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">{{ __('Cancelar') }}</x-link>
    </div>
</form>
