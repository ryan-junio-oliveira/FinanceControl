@props([
    'cols' => 0,
    'icon' => 'folder-open',
    'title' => '',
    'message' => '',
    'buttonUrl' => null,
    'buttonLabel' => null,
    'buttonClass' => 'bg-emerald-600'
])

<tr>
    <td colspan="{{ $cols }}" class="px-6 py-12 text-center">
        <div class="mx-auto max-w-md mt-4">
            <div class="text-3xl text-gray-300">
                <x-fa-icon name="{{ $icon }}" class="h-12 w-12 text-gray-300" />
            </div>
            @if($title)
                <p class="text-sm text-gray-500">{{ $title }}</p>
            @endif
            @if($message)
                <p class="text-sm text-gray-500 mt-1">{{ $message }}</p>
            @endif
            @if($buttonUrl && $buttonLabel)
                <div class="mt-4">
                    <a href="{{ $buttonUrl }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded {{ $buttonClass }} text-white text-sm">
                        {{ $buttonLabel }}
                    </a>
                </div>
            @endif
        </div>
    </td>
</tr>
