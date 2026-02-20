@extends('layouts.app')

@section('page_title', 'Nova Receita')

@section('content')
<div class="max-w-2xl mx-auto">


    <x-form-layout
        title="Nova Receita"
        subtitle="Registre uma entrada financeira"
        back-url="{{ route('recipes.index') }}"
        form-action="{{ route('recipes.store') }}"
        cancel-url="{{ route('recipes.index') }}"
        submit-label="Salvar"
    >
        <x-form-input name="name" label="Nome" :value="old('name')" required placeholder="Ex: Salário, Freelance" />
        <x-form-input name="amount" label="Valor (R$)" type="number" :value="old('amount')" step="0.01" required placeholder="0,00" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-form-input name="transaction_date" label="Data da transação" type="date" :value="old('transaction_date')" />

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="" disabled selected>Selecione uma categoria</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="fixed" :checked="old('fixed')" />
            <span class="text-sm font-medium text-gray-700">Receita fixa (recorrente)</span>
        </label>
    </x-form-layout>
</div>
@endsection
