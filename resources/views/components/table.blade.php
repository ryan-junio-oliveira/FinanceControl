@props([
    'columns' => [],
    'id' => null,
    'tbodyClass' => '',
])

<div class="w-full overflow-x-auto">
    <table @if($id) id="{{ $id }}" @endif class="min-w-full text-sm">

        @if(count($columns))
            <thead>
                <tr class="bg-cyan-900 text-white">
                    @foreach($columns as $column)
                        <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-widest whitespace-nowrap {{ $column['class'] ?? 'text-left' }}">
                            {{ $column['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="divide-y divide-gray-100 {{ $tbodyClass }}">
            {{ $slot }}
        </tbody>

    </table>
</div>
