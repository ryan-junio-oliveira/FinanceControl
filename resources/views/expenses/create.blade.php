@extends('layouts.app')

@section('title', 'Nova Despesa')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Nova Despesa</h1>

    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6">
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


        <div>
            <label for="monthly_financial_control_id" class="block text-sm font-medium text-gray-700 mb-1">Vínculo com Controle Mensal <span class="text-red-500">*</span></label>
            <select id="monthly_financial_control_id" name="monthly_financial_control_id" required
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                <option value="">Selecione o controle mensal</option>
                @foreach($controls as $control)
                    <option value="{{ $control->id }}" {{ old('monthly_financial_control_id') == $control->id ? 'selected' : '' }}>
                        {{ str_pad($control->month, 2, '0', STR_PAD_LEFT) }}/{{ $control->year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-2">
            <input id="fixed" name="fixed" type="checkbox" value="1" {{ old('fixed') ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="fixed" class="text-sm text-gray-700">Despesa fixa</label>
        </div>

        <button type="submit"
                class="w-full py-3 rounded-xl bg-linear-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 active:scale-[0.99] transition-all duration-200 cursor-pointer">
            Salvar Despesa
        </button>
    </form>
</div>
@endsection
