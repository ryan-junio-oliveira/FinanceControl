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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center gap-2 text-sm font-medium text-gray-900">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold">{{ sprintf('%02d', $control->month) }}</span>
                            {{ sprintf('%02d / %d', $control->month, $control->year) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('monthly-controls.edit', $control) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" aria-label="Editar">
                                <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                            </a>
                            <form action="{{ route('monthly-controls.destroy', $control) }}" method="POST" onsubmit="return confirm('Remover controle mensal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" aria-label="Remover">
                                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9M21 6H3m16 0l-1 14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2L3 6"/></svg>
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
