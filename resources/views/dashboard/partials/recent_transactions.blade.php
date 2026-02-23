@if (isset($recentTransactions) && $recentTransactions->count())
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Últimas Transações</h3>
        <x-table :columns="[
            ['label' => 'Tipo'],
            ['label' => 'Descrição'],
            ['label' => 'Data'],
            ['label' => 'Valor', 'class' => 'text-right'],
        ]" class="text-gray-600">
            @foreach ($recentTransactions as $tx)
                <tr
                    class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- type icon and text --}}
                        <div class="flex items-center gap-2">
                            <x-fa-icon name="{{ $tx->type_icon }}" class="h-4 w-4 text-gray-600" />
                            <span class="text-sm font-medium truncate">{{ $tx->type }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $tx->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        {{ $tx->amountFormatted }}
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>
@else
    <div class="flex items-center justify-center h-28 text-gray-400 text-sm">
        Nenhuma transação encontrada.
    </div>
@endif
