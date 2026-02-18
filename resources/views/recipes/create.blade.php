@extends('layouts.app')

@section('title', 'Nova Receita')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Nova Receita</h1>
    <form method="POST" action="{{ route('recipes.store') }}" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
            <input id="name" name="name" type="text" required maxlength="100" value="{{ old('name') }}"
                   class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
            <input id="amount" name="amount" type="number" step="0.01" min="0" required value="{{ old('amount') }}"
                   class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>
        <div>
            <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-1">Data</label>
            <input id="transaction_date" name="transaction_date" type="date" required value="{{ old('transaction_date') }}"
                   class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>
        <div class="flex items-center gap-2">
            <input id="received" name="received" type="checkbox" value="1" {{ old('received') ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="received" class="text-sm text-gray-700">Receita recebida</label>
        </div>
        <button type="submit"
                class="w-full py-3 rounded-xl bg-linear-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 active:scale-[0.99] transition-all duration-200 cursor-pointer">
            Salvar Receita
        </button>
    </form>
</div>
@endsection
