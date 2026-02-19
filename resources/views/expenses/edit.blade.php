@extends('layouts.app')

@section('page_title', 'Editar Despesa')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Despesa</h1>
        <a href="{{ route('expenses.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('expenses.update', $expense) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <x-form-input name="name" :value="old('name', $expense->name)" required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Valor (R$)</label>
            <x-form-input name="amount" type="number" step="0.01" :value="old('amount', $expense->amount)" required />
        </div>

        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2">
                <x-form-checkbox name="fixed" :checked="old('fixed', $expense->fixed)" />
                <span class="text-sm">Despesa fixa</span>
            </label>

            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Data da transação</label>
                <x-form-input name="transaction_date" type="date" :value="old('transaction_date', $expense->transaction_date?->format('Y-m-d'))" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Categoria</label>
                <select name="category_id" required class="w-full rounded-lg border px-3 py-2">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (old('category_id', $expense->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Controle Mensal (opcional)</label>
                <select name="monthly_financial_control_id" class="w-full rounded-lg border px-3 py-2">
                    <option value="">Auto (criar/associar)</option>
                    @foreach($controls as $c)
                        <option value="{{ $c->id }}" {{ old('monthly_financial_control_id', $expense->monthly_financial_control_id) == $c->id ? 'selected' : '' }}>{{ sprintf('%02d/%d', $c->month, $c->year) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Cartão (opcional)</label>
            <select name="credit_card_id" class="w-full rounded-lg border px-3 py-2">
                <option value="">Nenhum</option>
                @foreach($creditCards as $card)
                    <option value="{{ $card->id }}" {{ (old('credit_card_id', $expense->credit_card_id) == $card->id) ? 'selected' : '' }}>{{ $card->name }} — {{ $card->bank }}</option>
                @endforeach
            </select>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Atualizar</button>
            <a href="{{ route('expenses.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection
