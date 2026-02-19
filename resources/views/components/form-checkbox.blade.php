@props(['name', 'label' => null, 'checked' => false])

@php
    $id = $attributes->get('id') ?? $name;
@endphp

<div class="flex items-center gap-2">
    <input id="{{ $id }}" name="{{ $name }}" type="checkbox" value="1" {{ $checked ? 'checked' : '' }} {{ $attributes->merge(['class' => 'rounded']) }} />
    @if($label)
        <label for="{{ $id }}" class="text-sm text-gray-700">{{ $label }}</label>
    @endif
</div>
@error($name)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
@enderror