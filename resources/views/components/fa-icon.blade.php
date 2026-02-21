@props(['name', 'class' => '', 'style' => ''])

<i {{ $attributes->merge(['class' => "justify-center items-center fa-solid fa-$name $class"]) }} style="{{ $style }}"></i>
