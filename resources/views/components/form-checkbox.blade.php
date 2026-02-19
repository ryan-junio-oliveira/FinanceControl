@props(['name', 'label' => null, 'checked' => false])

@php
    $id = $attributes->get('id') ?? $name;
@endphp

<div class="flex items-center gap-2">
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="checkbox"
        value="1"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500/30 cursor-pointer']) }}
    />
    @if($label)
        <label for="{{ $id }}" class="text-sm font-medium text-gray-700 cursor-pointer select-none">{{ $label }}</label>
    @endif
</div>
@error($name)
    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
@enderror