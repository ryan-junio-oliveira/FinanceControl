@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-list-layout title="Orçamentos" subtitle="Gerencie seus orçamentos" create-url="{{ route('budgets.create') }}"
            create-label="Novo orçamento">

            <x-slot name="summary">
                <x-summary-cards>
                    <x-card label="Planejado (total)" :value="$budgets->sum('amount')" icon="fa-calendar-days" color="bg-emerald-600" />
                    <x-card label="Orçamentos" :value="$budgets->count()" icon="fa-list" color="bg-gray-700" />
                    <x-card label="Gasto (estim.)" :value="$budgets->sum(fn($b) => $b->spent())" icon="fa-chart-line" color="bg-amber-500" />
                </x-summary-cards>
            </x-slot>

            <div class="overflow-x-auto">
                @php
                    $columns = [
                        ['label' => 'Nome', 'class' => 'text-left'],
                        ['label' => 'Categoria', 'class' => 'text-left'],
                        ['label' => 'Período', 'class' => 'text-left'],
                        ['label' => 'Planejado', 'class' => 'text-right'],
                        ['label' => 'Gasto', 'class' => 'text-right'],
                        ['label' => 'Progresso', 'class' => 'text-left'],
                        ['label' => 'Ações', 'class' => 'text-right'],
                    ];
                @endphp

                <x-table :columns="$columns" id="budgets-table" tbody-class="bg-white divide-y divide-gray-100">
                    @forelse($budgets as $b)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $b->name }}</td>
                            <td class="px-6 py-4">{{ $b->category?->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $b->start_date->format('d/m/Y') }} —
                                {{ $b->end_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">R$ {{ number_format($b->amount, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">R$ {{ number_format($b->spent(), 2, ',', '.') }}</td>
                            <td class="px-6 py-4 w-48">
                                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                    <div class="h-3 bg-green-500" style="width: {{ $b->progressPercent() }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $b->progressPercent() }}%</div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('budgets.show', $b) }}" class="text-gray-600 mr-2">Ver</a>
                                <a href="{{ route('budgets.edit', $b) }}" class="text-blue-600 mr-2">Editar</a>
                                <form action="{{ route('budgets.destroy', $b) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Remover orçamento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <div class="text-3xl text-gray-300 mb-3">—</div>
                                    <p class="text-sm text-gray-500">Nenhum orçamento encontrado.</p>
                                    <div class="mt-4">
                                        <a href="{{ route('budgets.create') }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded bg-emerald-600 text-white text-sm">Novo
                                            orçamento</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>

            <x-slot name="pagination">
                <div class="mt-4">{{ $budgets->links() }}</div>
            </x-slot>

        </x-list-layout>
    @endsection
