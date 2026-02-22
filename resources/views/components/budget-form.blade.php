@props([        
    'model' => null,
    'categories' => [],
    'action',
    'method' => 'POST',
    'buttonLabel',
    'backUrl'
])

@php
    $nameVal = old('name', $model?->name() ?? '');
    $amountVal = old('amount', $model?->amount() ?? '');
    $startVal = old('start_date', isset($model) && $model->startDate() ? $model->startDate()->format('Y-m-d') : '');
    $endVal = old('end_date', isset($model) && $model->endDate() ? $model->endDate()->format('Y-m-d') : '');
    $categoryVal = old('category_id', $model?->categoryId() ?? '');
    $activeVal = old('is_active', $model?->isActive() ?? true);
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="{{ __('Nome') }}" :value="$nameVal" required placeholder="{{ __('Ex: Mercado, Transporte') }}" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <x-form-input name="amount" label="{{ __('Valor planejado (R$)') }}" type="number" step="0.01" :value="$amountVal" required placeholder="0,00" />
            <x-form-input name="start_date" label="{{ __('Data início') }}" type="date" :value="$startVal" required />
            <x-form-input name="end_date" label="{{ __('Data fim') }}" type="date" :value="$endVal" required />
        </div>

        <div>
            <x-form-select
                name="category_id"
                label="{{ __('Categoria') }}"
                :options="$categories"
                :value="$categoryVal"
                nullable-option="{{ __('Nenhuma (todas as categorias)') }}"
            />
        </div>

        <x-form-checkbox name="is_active" :checked="$activeVal" label="{{ __('Orçamento ativo') }}" class="cursor-pointer" />
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">Cancelar</x-link>
    </div>
</form>
