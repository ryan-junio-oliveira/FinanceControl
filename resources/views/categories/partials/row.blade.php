<tr class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
    <td class="px-6 py-4 whitespace-nowrap font-medium text-heading">{{ $category->name }}</td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if ($category->type === 'recipe')
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                {{ __('Receita') }}
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                {{ __('Despesa') }}
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->created_at->format('d/m/Y') }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <x-link variant="ghost" href="{{ route('categories.edit', $category) }}" class="inline-flex items-center justify-center rounded-md text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 p-0" aria-label="{{ __('Editar categoria :name', ['name' => $category->name]) }}">
                <x-fa-icon name="pen" class="w-4 h-4 text-current" />
            </x-link>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('Remover categoria?') }}');">
                @csrf
                @method('DELETE')
                <x-button variant="ghost" type="submit" class="inline-flex items-center justify-center rounded-md text-gray-500 hover:text-red-600 hover:bg-red-50 p-0" aria-label="{{ __('Remover categoria :name', ['name' => $category->name]) }}">
                    <x-fa-icon name="trash" class="w-4 h-4 text-current" />
                </x-button>
            </form>
        </div>
    </td>
</tr>
