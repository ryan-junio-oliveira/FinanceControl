@extends('layouts.app')

@section('page_title', 'Controles Mensais')

@section('content')
    <x-list-layout
        title="Controles Mensais"
        subtitle="Gerencie os períodos financeiros"
        create-url="{{ route('monthly-controls.create') }}"
        create-label="Novo mês"
        create-color="bg-indigo-600"
    >

        @php
            $columns = [
                ['label' => 'Mês / Ano', 'class' => 'text-left'],
                ['label' => 'Ações', 'class' => 'text-right'],
            ];
        @endphp

        <x-table compact :columns="$columns" id="monthly-controls-table" tbody-class="bg-white divide-y divide-gray-100">
            @forelse($controls as $control)
                <tr class="group hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5 whitespace-nowrap">
                        <span class="inline-flex items-center gap-2 text-sm font-medium text-gray-900">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold">{{ sprintf('%02d', $control->month) }}</span>
                            {{ sprintf('%02d / %d', $control->month, $control->year) }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('monthly-controls.edit', $control) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" aria-label="Editar">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </a>
                            <form action="{{ route('monthly-controls.destroy', $control) }}" method="POST" onsubmit="return confirm('Remover controle mensal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" aria-label="Remover">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-12 text-center" colspan="2">
                        <p class="text-sm text-gray-400">Nenhum controle mensal encontrado.</p>
                        <div class="mt-4">
                            <a href="{{ route('monthly-controls.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium shadow-sm">Novo mês</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table>

        <x-slot name="pagination">
            @if($controls->hasPages())
                <div class="mt-4">{{ $controls->links() }}</div>
            @endif
        </x-slot>

    </x-list-layout>
@endsection
