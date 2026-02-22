<tr class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-cyan-100 text-cyan-700 text-sm font-semibold">
                {{ strtoupper(mb_substr($budget->name(), 0, 1)) }}
            </div>
            <span class="text-sm font-medium text-heading">{{ $budget->name() }}</span>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $budget->category?->name ?? '-' }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $budget->startDate()->format('d/m/Y') }} — {{ $budget->endDate()->format('d/m/Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold tabular-nums text-heading">
        R$ {{ number_format($budget->amount(), 2, ',', '.') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold tabular-nums text-heading">
        R$ {{ number_format($budget->spent(), 2, ',', '.') }}
    </td>
    <td class="px-6 py-4 w-48">
        <div class="w-full bg-neutral-secondary-medium rounded-full h-2 overflow-hidden">
            <div class="h-2 rounded-full bg-emerald-500 transition-all" style="width: {{ $budget->progressPercent() }}%"></div>
        </div>
        <div class="text-xs text-gray-500 mt-1">{{ $budget->progressPercent() }}%</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right">
        <div class="flex items-center justify-end gap-1">
            <x-link href="{{ route('budgets.show', ['id' => $budget->id()]) }}" variant="ghost" aria-label="Ver orçamento {{ $budget->name() }}" class="h-8 w-8">
                <x-fa-icon name="eye" class="h-3.5 w-3.5 text-current" />
            </x-link>
            <x-link href="{{ route('budgets.edit', ['id' => $budget->id()]) }}" variant="ghost" aria-label="Editar orçamento {{ $budget->name() }}" class="h-8 w-8">
                <x-fa-icon name="pen" class="h-3.5 w-3.5 text-current" />
            </x-link>
            <form action="{{ route('budgets.destroy', ['id' => $budget->id()]) }}" method="POST"
                onsubmit="return confirm('Remover orçamento?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="ghost" aria-label="Remover orçamento {{ $budget->name() }}" class="h-8 w-8 bg-red-100 text-red-500 hover:text-white hover:bg-red-500 focus:ring-2 focus:ring-red-200">
                    <x-fa-icon name="trash" class="h-3.5 w-3.5 text-current" />
                </x-button>
            </form>
        </div>
    </td>
</tr>
