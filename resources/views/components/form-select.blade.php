@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'placeholder' => null,
    'nullableOption' => null,
    'required' => false,
    'class' => '',
])

@php
    /**
     * Normalize options into array of ['value'=>..., 'label'=>...]
     */
    $opts = collect($options)->map(function ($o, $k) {
        if (is_array($o)) {
            return [
                'value' => $o['value'] ?? $o['id'] ?? $k,
                'label' => $o['label'] ?? $o['name'] ?? $o,
            ];
        }
        if (is_object($o)) {
            return [
                'value' => $o->id ?? $o->value ?? $k,
                'label' => $o->name ?? $o->label ?? (string) $o,
            ];
        }
        // primitive (string, number) – key becomes value
        return [
            'value' => $k,
            'label' => $o,
        ];
    })->all();
@endphp

<div>
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}@if($required) <span class="text-rose-500">*</span>@endif
        </label>
    @endif
    <select name="{{ $name }}" @if($required) required @endif {{ $attributes->merge(['class' => "w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 $class"]) }}>
        @if ($nullableOption)
            <option value="">{{ $nullableOption }}</option>
        @elseif ($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        @foreach($opts as $opt)
            <option value="{{ $opt['value'] }}" @selected((string)($value) === (string)$opt['value'])>
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>
</div>
