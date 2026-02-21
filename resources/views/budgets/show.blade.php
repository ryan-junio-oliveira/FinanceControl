@extends('layouts.app')

@section('page_title', 'Orçamento')

@section('content')
<div class="max-w-4xl">

    {{-- Page header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('budgets.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <x-fa-icon name="arrow-left" class="h-4 w-4" />
        </a>
        <div class="flex-1">
            <h1 class="text-xl font-semibold text-gray-900">{{ $budget->name() }}</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ $categoryName ?? 'Sem categoria' }} — {{ $budget->startDate()->format('d/m/Y') }} até {{ $budget->endDate()->format('d/m/Y') }}</p>
        </div>
        <x-link variant="primary" href="{{ route('budgets.edit', ['id' => $budget->id()]) }}">
            <x-fa-icon name="pen" class="h-3.5 w-3.5" />
            Editar
        </x-link>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Planejado</p>
            <p class="text-2xl font-bold text-gray-900 mt-1 tabular-nums">R$ {{ number_format($budget->amount(), 2, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Gasto</p>
            <p class="text-2xl font-bold mt-1 tabular-nums {{ $spent > $budget->amount() ? 'text-red-600' : 'text-gray-900' }}">R$ {{ number_format($spent, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Progresso</p>
            <p class="text-2xl font-bold text-gray-900 mt-1 tabular-nums">{{ $progress }}%</p>
        </div>
    </div>

    {{-- Progress bar --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
        @php $pct = min($progress, 100); $over = $progress > 100; @endphp
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">Utilização</span>
            <span class="text-sm font-bold {{ $over ? 'text-red-600' : 'text-gray-800' }}">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
            <div class="h-3 rounded-full transition-all {{ $over ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ $pct }}%"></div>
        </div>
        @if($over)
            <p class="text-xs text-red-500 mt-2">Orçamento excedido!</p>
        @endif
    </div>

    {{-- Transactions table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Lançamentos no período</h2>
        </div>

        {{-- expenses provided by controller --}}
        @php
            /** @var \Illuminate\Support\Collection $expenses */
        @endphp

        @if($expenses->count() > 0)
            <x-table :columns="[
                ['label' => 'Data'],
                ['label' => 'Nome'],
                ['label' => 'Categoria'],
                ['label' => 'Valor', 'class' => 'text-right'],
            ]">
                    @foreach($expenses as $e)
                    <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                        <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $e->transaction_date?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $e->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $e->category?->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-right font-semibold tabular-nums text-gray-900">R$ {{ number_format($e->amount, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-12 text-center">
                <p class="text-sm text-gray-400">Nenhum lançamento encontrado no período.</p>
            </div>
        @endif
    </div>
</div>
@endsection
