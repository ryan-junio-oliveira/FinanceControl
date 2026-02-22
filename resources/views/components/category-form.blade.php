@props([
    'model' => null,
    'types' => [],
    'action',
    'method' => 'POST',
    'buttonLabel',
    'backUrl',
])

@php
    $nameVal = old('name', $model->name ?? '');
    $typeVal = old('type', $model->type ?? '');
@endphp

<form action="{{ $action }}" method="POST" class="divide-y divide-gray-100">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="p-6 space-y-5">
        <x-form-input name="name" label="{{ __('Nome') }}" :value="$nameVal" required placeholder="{{ __('Ex: Alimentação, Salário') }}" />

        <div>
            @php
                $typeOptions = collect($types)->map(function($label, $key) {
                    return ['value' => $key, 'label' => $label];
                });
            @endphp
            <x-form-select
                name="type"
                label="{{ __('Tipo') }}"
                :options="$typeOptions"
                :value="$typeVal"
                required
            />
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">{{ __('Cancelar') }}</x-link>
    </div>
</form>
