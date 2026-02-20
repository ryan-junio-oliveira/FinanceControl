@extends('layouts.app')

@section('page_title', 'Novo Cartão')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Novo Cartão de Crédito"
        subtitle="Adicione um cartão à sua organização"
        back-url="{{ route('credit-cards.index') }}"
        form-action="{{ route('credit-cards.store') }}"
        cancel-url="{{ route('credit-cards.index') }}"
        submit-label="Salvar"
    >
        <x-form-input name="name" label="Nome do cartão" :value="old('name')" required placeholder="Ex: Nubank, Inter, Bradesco" />

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banco <span class="text-rose-500">*</span></label>
            <select name="bank_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="" disabled selected>Selecione um banco</option>
                @foreach($banks as $b)
                    <option value="{{ $b->id }}" {{ old('bank_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="statement_amount" label="Valor da fatura (R$)" type="number" step="0.01" :value="old('statement_amount')" required placeholder="0,00" />
            <x-form-input name="limit" label="Limite (opcional)" type="number" step="0.01" :value="old('limit')" placeholder="0,00" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="closing_day" label="Dia de fechamento (1-31)" type="number" min="1" max="31" :value="old('closing_day')" placeholder="Ex: 28" />
            <x-form-input name="due_day" label="Dia de vencimento (1-31)" type="number" min="1" max="31" :value="old('due_day')" placeholder="Ex: 5" />
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <x-form-checkbox name="is_active" :checked="old('is_active', 1)" />
                <span class="text-sm font-medium text-gray-700">Cartão ativo</span>
            </label>

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cor <span class="text-xs text-gray-400">(opcional)</span></label>
                <div class="flex items-center gap-2">
                    <input type="color" value="{{ old('color', '#005E7D') }}"
                        oninput="document.getElementById('card_color_text').value = this.value"
                        class="h-9 w-10 cursor-pointer rounded-lg border border-gray-200 p-1 shadow-sm" />
                    <x-form-input name="color" id="card_color_text" :value="old('color')" placeholder="#RRGGBB" class="flex-1" />
                </div>
            </div>
        </div>
    </x-form-layout>
</div>
@endsection