@extends('layouts.app')

@section('page_title', 'Editar Receita')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Receita</h1>
        <a href="{{ route('recipes.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('recipes.update', $recipe) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <input name="name" value="{{ old('name', $recipe->name) }}" required class="w-full rounded-lg border px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Valor (R$)</label>
            <input name="amount" type="number" step="0.01" value="{{ old('amount', $recipe->amount) }}" required class="w-full rounded-lg border px-3 py-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Data da transação</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', $recipe->transaction_date?->format('Y-m-d')) }}" class="w-full rounded-lg border px-3 py-2" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Categoria</label>
                <select name="category_id" required class="w-full rounded-lg border px-3 py-2">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (old('category_id', $recipe->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="fixed" value="1" class="rounded" {{ old('fixed', $recipe->fixed) ? 'checked' : '' }} />
                <span class="text-sm">Receita fixa</span>
            </label>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Atualizar</button>
            <a href="{{ route('recipes.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection
