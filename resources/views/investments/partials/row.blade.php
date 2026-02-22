<tr class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
    {{-- Nome --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-sm font-semibold">
                {{ strtoupper(mb_substr($investment->name, 0, 1)) }}
            </div>

            <div class="min-w-0">
                <div class="text-sm font-medium text-heading truncate">
                    {{ $investment->name }}
                </div>

            </div>
        </div>
    </td>

    {{-- Valor --}}
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <span class="text-sm font-semibold tabular-nums text-emerald-600">
            R$ {{ number_format($investment->amount, 2, ',', '.') }}
        </span>
    </td>

    {{-- Fixa --}}
    <td class="px-6 py-4 whitespace-nowrap text-center">
        @if ($investment->fixed)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                {{ __('Sim') }}
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                {{ __('Não') }}
            </span>
        @endif
    </td>

    {{-- Data --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        @if ($investment->transaction_date)
            <div class="flex items-center gap-1.5">
                <x-fa-icon name="calendar" class="h-3.5 w-3.5 text-emerald-600" />
                {{ \Carbon\Carbon::parse($investment->transaction_date)->format('d/m/Y') }}
            </div>
        @else
            <span class="text-gray-300">—</span>
        @endif
    </td>

    {{-- Ações --}}
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="flex items-center justify-end gap-1">

            {{-- Editar --}}
            <x-link href="{{ route('investments.edit', $investment) }}" variant="ghost" aria-label="{{ __('Editar investimento :name', ['name' => $investment->name]) }}" class="inline-flex items-center justify-center">
                <x-fa-icon name="pen" class="h-3.5 w-3.5 text-current" />
            </x-link>

            {{-- Excluir --}}
            <form action="{{ route('investments.destroy', $investment) }}" method="POST"
                onsubmit="return confirm('{{ __('Tem certeza que deseja remover este investimento?') }}');">
                @csrf
                @method('DELETE')

                <x-button type="submit" variant="ghost" aria-label="{{ __('Remover investimento :name', ['name' => $investment->name]) }}" class="inline-flex items-center justify-center bg-emerald-100 text-emerald-500 hover:text-white hover:bg-emerald-500 focus:ring-2 focus:ring-emerald-200">
                    <x-fa-icon name="trash" class="h-3.5 w-3.5 text-current" />
                </x-button>
            </form>
        </div>
    </td>
</tr>