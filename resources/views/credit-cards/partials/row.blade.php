<tr class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-orange-100 text-orange-600 text-sm font-semibold">
                {{ strtoupper(mb_substr($card->name, 0, 1)) }}
            </div>
            <span class="text-sm font-medium text-heading">{{ $card->name }}</span>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $card->bankName }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <span class="text-sm font-semibold tabular-nums text-red-600">
            − R$ {{ number_format($card->statementAmount(), 2, ',', '.') }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold tabular-nums text-heading">
        R$ {{ number_format($card->limit() ?? 0, 2, ',', '.') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <div class="flex items-center gap-1.5">
            <x-fa-icon name="calendar" class="h-3.5 w-3.5 text-gray-400" />
            {{ $card->closingDay() ?? '-' }} / {{ $card->dueDay() ?? '-' }}
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-center">
        @if ($card->isActive())
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                {{ __('Sim') }}
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-neutral-secondary-medium text-gray-500">
                <span class="h-1.5 w-1.5 rounded-full"></span>
                {{ __('Não') }}
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="flex items-center justify-end gap-1">
            <a href="{{ route('credit-cards.edit', $card->id) }}"
               class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-blue-100
                      text-blue-500 hover:text-white hover:bg-blue-500
                      transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400/40"
               aria-label="{{ __('Editar cartão :name', ['name' => $card->name]) }}">
                <x-fa-icon name="pen" class="h-3.5 w-3.5 text-current" />
            </a>
            <form action="{{ route('credit-cards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('{{ __('Remover cartão?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-red-100
                           text-red-500 hover:text-white hover:bg-red-500
                           transition-colors focus:outline-none focus:ring-2 focus:ring-red-200"
                    aria-label="{{ __('Remover cartão :name', ['name' => $card->name]) }}">
                    <x-fa-icon name="trash" class="h-3.5 w-3.5 text-current" />
                </button>
            </form>
        </div>
    </td>
</tr>
