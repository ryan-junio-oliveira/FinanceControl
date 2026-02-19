@props(['href' => null, 'type' => 'button'])

@php
$base = 'inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-500 text-white text-sm font-semibold shadow-sm hover:bg-brand-600 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500/30';
@endphp

@if($href)
<a {{ $attributes->merge(['href' => $href, 'class' => $base]) }}>{{ $slot }}</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $base]) }}>{{ $slot }}</button>
@endif