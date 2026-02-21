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
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Tipo') }} <span class="text-rose-500">*</span></label>
            <select name="type" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" @selected((string)$typeVal === (string)$key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
        <x-button variant="primary" type="submit">{{ __($buttonLabel) }}</x-button>
        <x-link variant="secondary" href="{{ $backUrl }}">{{ __('Cancelar') }}</x-link>
    </div>
</form>
