@extends('layouts.app')

@section('page_title', 'Nova Receita')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Nova Receita</h1>
        <a href="{{ route('recipes.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('recipes.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <x-form-input name="name" :value="old('name')" required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Valor (R$)</label>
            <x-form-input name="amount" type="number" :value="old('amount')" step="0.01" required />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Data da transação</label>
                <x-form-input name="transaction_date" type="date" :value="old('transaction_date')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Categoria</label>
                <select name="category_id" required class="w-full rounded-lg border px-3 py-2">
                    <option value="" disabled selected>Selecione uma categoria</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <label class="flex items-center gap-2">
                <x-form-checkbox name="fixed" :checked="old('fixed')" />
                <span class="text-sm">Receita fixa</span>
            </label>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white">Salvar</button>
            <a href="{{ route('recipes.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection
