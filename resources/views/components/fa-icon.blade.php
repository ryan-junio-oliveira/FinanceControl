@props(['name', 'class' => '', 'style' => ''])

<i {{ $attributes->merge(['class' => "fa-solid fa-$name $class"]) }} style="{{ $style }}"></i>
