{{--
    Button component used throughout the application to ensure consistent styling.
    Attributes:
      - variant: primary (default), secondary, ghost
      - href: if provided, renders an <a> tag; otherwise a <button>
      - type: button type when rendered as <button> (submit, button, etc.)
    Additional classes may be passed via the component's attributes.
--}}
@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
    $base = 'inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium shadow-sm transition';
    switch ($variant) {
        case 'secondary':
            $color = 'border bg-white text-gray-700 hover:bg-gray-50';
            break;
        case 'ghost':
            $color = 'text-gray-600 hover:bg-gray-50';
            break;
        default:
            $color = 'bg-brand-500 text-white hover:bg-brand-600';
            break;
    }
    $classes = trim("$base $color");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
