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
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Categoria') }} <span class="text-xs text-gray-400">({{ __('opcional') }})</span></label>
            <select name="category_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="">Nenhuma (todas as categorias)</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id() }}" @selected((string)$categoryVal === (string)$c->id())>{{ $c->name() }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="is_active" :checked="$activeVal" />
            <span class="text-sm font-medium text-gray-700">{{ __('Orçamento ativo') }}</span>
        </label>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">Cancelar</x-link>
    </div>
</form>
