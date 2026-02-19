<div class="relative rounded-xl {{ $color }} text-white p-6 shadow-md">
    <div class="text-sm uppercase opacity-80">
        {{ $label }}
    </div>

    <div class="mt-2 text-3xl font-bold">
        R$ {{ number_format($value, 2, ',', '.') }}
    </div>

    <i class="fa-solid {{ $icon }} absolute right-6 top-6 text-5xl opacity-20"></i>
</div>
