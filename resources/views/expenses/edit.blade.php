@extends('layouts.app')

@section('page_title', 'Editar Despesa')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Editar Despesa"
        subtitle="{{ $expense->name }}"
        back-url="{{ route('expenses.index') }}"
        form-action="{{ route('expenses.update', $expense) }}"
        cancel-url="{{ route('expenses.index') }}"
        submit-label="Salvar"
    >
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="name" label="Nome" :value="old('name', $expense->name)" required />
            <x-form-input name="amount" label="Valor (R$)" type="number" step="0.01" :value="old('amount', $expense->amount)" required />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
            <x-form-input name="transaction_date" label="Data da transação" type="date" :value="old('transaction_date', $expense->transaction_date?->format('Y-m-d'))" />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (old('category_id', $expense->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cartão <span class="text-xs text-gray-400">(opcional)</span></label>
            <select name="credit_card_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="">Nenhum</option>
                @foreach($creditCards as $card)
                    <option value="{{ $card->id }}" {{ (old('credit_card_id', $expense->credit_card_id) == $card->id) ? 'selected' : '' }}>{{ $card->name }} — {{ $card->bank }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="fixed" :checked="old('fixed', $expense->fixed)" />
            <span class="text-sm font-medium text-gray-700">Despesa fixa (recorrente)</span>
        </label>
    </x-form-layout>
</div>
@endsection
