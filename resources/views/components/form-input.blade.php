@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
])

@php
    $id = $attributes->get('id') ?? $name;
    $hasError = $errors->has($name);
    $inputClass = 'w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20';
    if ($hasError) {
        $inputClass .= ' border-red-400 ring-1 ring-red-200';
    } else {
        $inputClass .= ' border-gray-600';
    }
    $labelText = $label ?? ucwords(str_replace(['_', '-'], ' ', $name));
    $valueAttr = old($name, $value ?? '');
@endphp

<div class="space-y-1">
    @if($label !== false)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $labelText }}@if($required) <span class="text-rose-600">*</span>@endif</label>
    @endif

    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ $valueAttr }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => $inputClass]) }} />

    @error($name)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>