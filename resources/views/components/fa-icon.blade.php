@props(['name', 'class' => '', 'style' => ''])

<i {{ $attributes->merge(['class' => "inline-flex justify-center items-center fa-solid fa-$name $class"]) }} style="{{ $style }}"></i>
