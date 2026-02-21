@props([
    'ariaLabel' => null,
    'ariaDesc' => null,
    'class' => '',
    'columns' => null,
    'id' => null,
    'tbodyClass' => '',
    'compact' => false,
])

@php
    $isStructured = is_array($columns) && count($columns) > 0;
@endphp

<div 
    class="relative w-full overflow-x-auto rounded-base border border-default bg-neutral-primary-soft shadow-xs {{ $class }}"
    role="region"
    aria-label="{{ $ariaLabel ?? 'Data table' }}"
    @if ($ariaDesc) aria-describedby="{{ $ariaDesc }}" @endif
>
    <table 
        @if ($id) id="{{ $id }}" @endif
        class="w-full text-sm text-left rtl:text-right text-body {{ $compact ? 'text-xs' : '' }}"
        role="table"
    >
        @if ($isStructured)
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    @foreach ($columns as $col)
                        @php $colClass = $col['class'] ?? ''; @endphp
                        <th
                            scope="col"
                            class="sticky top-0 bg-neutral-secondary-medium z-10 px-6 {{ $compact ? 'py-2' : 'py-3' }} text-left font-medium text-body {{ $colClass }}"
                        >
                            {{ $col['label'] ?? '' }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="{{ $tbodyClass }}">
                {{ $slot }}
            </tbody>
        @else
            {{ $slot }}
        @endif
    </table>
</div>