@props(['class' => ''])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-8 {{ $class }}">
    {{ $slot }}
</div>