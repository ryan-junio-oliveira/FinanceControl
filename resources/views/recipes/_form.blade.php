@php
    $nameVal = old('name', $model->name ?? '');
    $amountVal = old('amount', $model->amount ?? '');
    $dateVal = old('transaction_date', isset($model->transaction_date) ? $model->transaction_date->format('Y-m-d') : '');
    $categoryIdVal = old('category_id', $model->category_id ?? '');
    $fixedVal = old('fixed', $model->fixed ?? false);
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if(!empty($method) && strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="Nome" :value="$nameVal" required placeholder="Ex: Salário, Freelance" />
        <x-form-input name="amount" label="Valor (R$)" type="number" :value="$amountVal" step="0.01" required placeholder="0,00" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="transaction_date" label="Data da transação" type="date" :value="$dateVal" />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="" disabled>{{ __('Selecione uma categoria') }}</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (string)$categoryIdVal === (string)$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="fixed" :checked="$fixedVal" />
            <span class="text-sm font-medium text-gray-700">Receita fixa (recorrente)</span>
        </label>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ $buttonLabel }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">Cancelar</x-link>
    </div>
</form>
