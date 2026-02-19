@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('budgets.index') }}" class="text-sm text-gray-500">Voltar</a>

    <h1 class="text-xl font-semibold mt-4 mb-4">Novo orçamento</h1>

    <form action="{{ route('budgets.store') }}" method="POST" class="form-erp bg-white p-4 rounded-md shadow-sm space-y-4">
        @csrf
        <div>
            <label class="text-sm text-gray-600">Nome</label>
            <x-form-input name="name" :value="old('name')" required />
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="text-sm text-gray-600">Valor planejado</label>
                <x-form-input name="amount" type="number" step="0.01" :value="old('amount')" required />
            </div>
            <div>
                <label class="text-sm text-gray-600">Data início</label>
                <x-form-input name="start_date" type="date" :value="old('start_date')" required />
            </div>
            <div>
                <label class="text-sm text-gray-600">Data fim</label>
                <x-form-input name="end_date" type="date" :value="old('end_date')" required />
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-600">Categoria (opcional)</label>
            <select name="category_id" class="w-full rounded-lg border px-3 py-2">
                <option value="">Nenhuma</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="inline-flex items-center gap-2 text-sm">
                <x-form-checkbox name="is_active" :checked="old('is_active', true)" />
                <span>Ativo</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button class="btn-primary">Salvar</button>
            <a href="{{ route('budgets.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
