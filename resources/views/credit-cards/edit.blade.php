@extends('layouts.app')

@section('page_title', 'Editar Cartão')

@section('content')
<div class="max-w-2xl">

    {{-- Page header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('credit-cards.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Editar Cartão</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ $creditCard->name }}</p>
        </div>
    </div>

    <x-form-errors />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('credit-cards.update', $creditCard) }}" method="POST" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-5">

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
                                class="h-9 w-10 cursor-pointer rounded-lg border border-gray-200 p-1" />
                            <x-form-input name="color" id="card_color_edit" :value="old('color', $creditCard->color)" placeholder="#RRGGBB" class="flex-1" />
                        </div>
                    </div>
                </div>

            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                <button type="submit" class="btn-primary">Atualizar</button>
                <a href="{{ route('credit-cards.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection