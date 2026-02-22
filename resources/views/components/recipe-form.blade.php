@props([
    'model' => null,
    'categories' => [],
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
    $fixedVal = old('fixed', $model?->fixed ?? false);
    $receivedVal = old('received', $model?->received ?? false);
    $receivedAtVal = '';
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="{{ __('Nome') }}" :value="$nameVal" required placeholder="{{ __('Ex: Salário, Freelance') }}" />
        <x-form-input name="amount" label="{{ __('Valor (R$)') }}" type="number" :value="$amountVal" step="0.01" required placeholder="0,00" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="transaction_date" label="{{ __('Data da transação') }}" type="date" :value="$dateVal" />

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
        </div>

        <x-form-checkbox name="fixed" :checked="$fixedVal" label="{{ __('Receita fixa (recorrente)') }}" class="cursor-pointer" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-checkbox name="received" :checked="$receivedVal" label="{{ __('Recebido') }}" class="cursor-pointer" />
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">{{ __('Cancelar') }}</x-link>
    </div>
</form>
