@extends('layouts.app')

@section('page_title', 'Editar Orçamento')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-errors />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <x-form-layout
        title="Editar Orçamento"
        subtitle="{{ $budget->name }}"
        back-url="{{ route('budgets.index') }}"
        form-action="{{ route('budgets.update', $budget) }}"
        cancel-url="{{ route('budgets.index') }}"
        submit-label="Atualizar"
    >
        @method('PUT')
        <x-form-input name="name" label="Nome" :value="old('name', $budget->name)" required />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <x-form-input name="amount" label="Valor planejado (R$)" type="number" step="0.01" :value="old('amount', $budget->amount)" required />
            <x-form-input name="start_date" label="Data início" type="date" :value="old('start_date', $budget->start_date?->format('Y-m-d'))" required />
            <x-form-input name="end_date" label="Data fim" type="date" :value="old('end_date', $budget->end_date?->format('Y-m-d'))" required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Categoria <span class="text-xs text-gray-400">(opcional)</span></label>
            <select name="category_id" class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option value="">Nenhuma (todas as categorias)</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (old('category_id', $budget->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <x-form-checkbox name="is_active" :checked="old('is_active', $budget->is_active)" />
            <span class="text-sm font-medium text-gray-700">Orçamento ativo</span>
        </label>
    </x-form-layout>
    </div>
</div>
@endsection
