<tr class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
    {{-- Nome --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 text-sm font-semibold">
                {{ strtoupper(mb_substr($expense->name, 0, 1)) }}
            </div>

            <div class="min-w-0">
                <div class="text-sm font-medium text-heading truncate">
                    {{ $expense->name }}
                </div>

                @if ($expense->paid)
                    <div class="inline-flex items-center gap-1 text-xs text-emerald-600 mt-0.5">
                        <x-fa-icon name="circle-check" class="h-3 w-3" />
                        {{ __('Pago em') }} {{ \Carbon\Carbon::parse($expense->paid_at)->format('d/m/Y') }}
                    </div>
                @else
                    <div class="inline-flex items-center gap-1 text-xs text-gray-400 mt-0.5">
                        <x-fa-icon name="clock" class="h-3 w-3" />
                        {{ __('Pendente') }}
                    </div>
                @endif
            </div>
        </div>
    </td>

    {{-- Valor --}}
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <span class="text-sm font-semibold tabular-nums text-red-600">
            − R$ {{ number_format($expense->amount, 2, ',', '.') }}
        </span>
    </td>

    {{-- Fixa --}}
    <td class="px-6 py-4 whitespace-nowrap text-center">
        @if ($expense->fixed)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
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
        @if ($expense->transaction_date)
            <div class="flex items-center gap-1.5">
                <x-fa-icon name="calendar" class="h-3.5 w-3.5 text-emerald-600" />
                {{ \Carbon\Carbon::parse($expense->transaction_date)->format('d/m/Y') }}
            </div>
        @else
            <span class="text-gray-300">—</span>
        @endif
    </td>

    {{-- Ações --}}
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="flex items-center justify-end gap-1">

            {{-- Editar --}}
            <a href="{{ route('expenses.edit', $expense) }}"
                class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-blue-100
                       text-blue-500 hover:text-white hover:bg-blue-500
                       transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                aria-label="{{ __('Editar despesa :name', ['name' => $expense->name]) }}">
                <x-fa-icon name="pen" class="h-3.5 w-3.5 text-current" />
            </a>

            {{-- Excluir --}}
            <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                onsubmit="return confirm('{{ __('Tem certeza que deseja remover esta despesa?') }}');">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-red-100
                           text-red-500 hover:text-white hover:bg-red-500
                           transition-colors focus:outline-none focus:ring-2 focus:ring-red-200"
                    aria-label="{{ __('Remover despesa :name', ['name' => $expense->name]) }}">
                    <x-fa-icon name="trash" class="h-3.5 w-3.5 text-current" />
                </button>
            </form>
        </div>
    </td>
</tr>
