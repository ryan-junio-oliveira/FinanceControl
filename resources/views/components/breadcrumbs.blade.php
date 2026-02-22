@props(['items' => []])

@if(count($items))
<nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
    <ol class="list-reset flex">
        @foreach($items as $i => $item)
            <li class="flex items-center">
                @if(isset($item['url']))
                    <a href="{{ $item['url'] }}" class="hover:underline text-gray-500">{{ $item['label'] }}</a>
                @else
                    <span class="font-semibold text-gray-700">{{ $item['label'] }}</span>
                @endif
                @if($i < count($items) - 1)
                    <span class="mx-2 text-gray-400">/</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
