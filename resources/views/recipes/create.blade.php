@extends('layouts.app')

@section('page_title', 'Nova Receita')

@section('content')
<div class="max-w-2xl">

    {{-- Page header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('recipes.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Nova Receita</h1>
            <p class="text-xs text-gray-400 mt-0.5">Registre uma entrada financeira</p>
        </div>
    </div>

    <x-form-errors />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('recipes.store') }}" method="POST" class="divide-y divide-gray-100">
            @csrf
            <div class="p-6 space-y-5">

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

            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                <button type="submit" class="btn-primary">Salvar</button>
                <a href="{{ route('recipes.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
