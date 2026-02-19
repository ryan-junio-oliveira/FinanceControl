@extends('layouts.app')

@section('page_title', 'Editar Cartão')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Cartão</h1>
        <a href="{{ route('credit-cards.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('credit-cards.update', $creditCard) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <x-form-input name="name" :value="old('name', $creditCard->name)" required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Banco</label>
            <select name="bank_id" required class="w-full rounded-lg border px-3 py-2">
                @foreach($banks as $b)
                    <option value="{{ $b->id }}" {{ (old('bank_id', $creditCard->bank_id) == $b->id) ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Valor da fatura (R$)</label>
                <x-form-input name="statement_amount" type="number" step="0.01" :value="old('statement_amount', $creditCard->statement_amount)" required />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Limite (opcional)</label>
                <x-form-input name="limit" type="number" step="0.01" :value="old('limit', $creditCard->limit)" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Dia de fechamento (1-31)</label>
                <x-form-input name="closing_day" type="number" min="1" max="31" :value="old('closing_day', $creditCard->closing_day)" />
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Dia de vencimento (1-31)</label>
                <x-form-input name="due_day" type="number" min="1" max="31" :value="old('due_day', $creditCard->due_day)" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2">
                <x-form-checkbox name="is_active" :checked="old('is_active', $creditCard->is_active)" />
                <span class="text-sm">Ativo</span>
            </label>

            <div>
                <label class="block text-sm font-medium mb-1">Cor (opcional)</label>
                <x-form-input name="color" :value="old('color', $creditCard->color)" class="w-24" placeholder="#RRGGBB" />
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Salvar</button>
            <a href="{{ route('credit-cards.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection