@props([
    'ariaLabel' => null,
    'ariaDesc' => null,
    'class' => '',
    'columns' => null, // array of ['label'=>..., 'class'=>..., 'sortable'=>bool]
    'id' => null,
    'tbodyClass' => 'bg-white divide-y divide-gray-100',
    'compact' => false,
])

<div class="overflow-x-auto w-full {{ $class }}" role="region" aria-label="{{ $ariaLabel ?? 'Data table' }}"
    @if ($ariaDesc) aria-describedby="{{ $ariaDesc }}" @endif>
    <table @if ($id) id="{{ $id }}" @endif class="min-w-full text-sm bg-white {{ $compact ? 'table-compact' : '' }}"
        role="table">
        @if (is_array($columns) && count($columns) > 0)
            <thead>
                <tr>
                    @foreach ($columns as $col)
                        @php $colClass = $col['class'] ?? 'text-left'; @endphp
                        <th
                            class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider {{ $colClass }}">
                            {{ $col['label'] ?? '' }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="{{ $tbodyClass }}">
                {{ $slot }}
            </tbody>
        @else
            {{-- fallback: allow caller to render full table (thead/tbody) via slot --}}
            {{ $slot }}
        @endif
    </table>
</div>
