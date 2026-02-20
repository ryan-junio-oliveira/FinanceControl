@extends('layouts.app')

@section('page_title', 'Editar Cartão')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Editar Cartão"
        subtitle="{{ $creditCard->name }}"
        back-url="{{ route('credit-cards.index') }}"
        form-action="{{ route('credit-cards.update', $creditCard) }}"
        cancel-url="{{ route('credit-cards.index') }}"
        submit-label="Salvar"
    >
        @method('PUT')
        <x-form-input name="name" label="Nome do cartão" :value="old('name', $creditCard->name)" required />

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Banco <span class="text-rose-500">*</span></label>
            <select name="bank_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                @foreach($banks as $b)
                    <option value="{{ $b->id }}" {{ (old('bank_id', $creditCard->bank_id) == $b->id) ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="statement_amount" label="Valor da fatura (R$)" type="number" step="0.01" :value="old('statement_amount', $creditCard->statement_amount)" required />
            <x-form-input name="limit" label="Limite (opcional)" type="number" step="0.01" :value="old('limit', $creditCard->limit)" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="closing_day" label="Dia de fechamento (1-31)" type="number" min="1" max="31" :value="old('closing_day', $creditCard->closing_day)" />
            <x-form-input name="due_day" label="Dia de vencimento (1-31)" type="number" min="1" max="31" :value="old('due_day', $creditCard->due_day)" />
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <x-form-checkbox name="is_active" :checked="old('is_active', $creditCard->is_active)" />
                <span class="text-sm font-medium text-gray-700">Cartão ativo</span>
            </label>

            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cor <span class="text-xs text-gray-400">(opcional)</span></label>
                <div class="flex items-center gap-2">
                    <input type="color" value="{{ old('color', $creditCard->color ?? '#005E7D') }}"
                        oninput="document.getElementById('card_color_edit').value = this.value"
                        class="h-9 w-10 cursor-pointer rounded-lg border border-gray-200 p-1 shadow-sm" />
                    <x-form-input name="color" id="card_color_edit" :value="old('color', $creditCard->color)" placeholder="#RRGGBB" class="flex-1" />
                </div>
            </div>
        </div>
    </x-form-layout>
</div>
@endsection