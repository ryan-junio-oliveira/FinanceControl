@extends('layouts.app')

@section('page_title', 'Nova Despesa')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Nova Despesa"
        subtitle="Registre uma saída financeira"
        back-url="{{ route('expenses.index') }}"
        form-action="{{ route('expenses.store') }}"
        cancel-url="{{ route('expenses.index') }}"
        submit-label="Salvar"
    >
        <x-form-input name="name" label="Nome" :value="old('name')" required placeholder="Ex: Conta de luz, Mercado" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="amount" label="Valor (R$)" type="number" step="0.01" :value="old('amount')" required placeholder="0,00" />
            <x-form-input name="transaction_date" label="Data da transação" type="date" :value="old('transaction_date')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="" disabled selected>Selecione uma categoria</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Controle Mensal <span class="text-xs text-gray-400">(opcional)</span></label>
                <select name="monthly_financial_control_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="">Auto (criar/associar)</option>
                    @foreach($controls as $c)
                        <option value="{{ $c->id }}">{{ sprintf('%02d/%d', $c->month, $c->year) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cartão <span class="text-xs text-gray-400">(opcional)</span></label>
            <select name="credit_card_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="">Nenhum</option>
                @foreach($creditCards as $card)
                    <option value="{{ $card->id }}" {{ old('credit_card_id') == $card->id ? 'selected' : '' }}>{{ $card->name }} — {{ $card->bank }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="fixed" :checked="old('fixed')" />
            <span class="text-sm font-medium text-gray-700">Despesa fixa (recorrente)</span>
        </label>
    </x-form-layout>
</div>
@endsection
