@props(['class' => ''])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-6 {{ $class }}">
    {{ $slot }}
</div>