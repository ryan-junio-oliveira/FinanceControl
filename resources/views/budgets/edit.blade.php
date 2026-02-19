@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('budgets.index') }}" class="text-sm text-gray-500">Voltar</a>

    <h1 class="text-xl font-semibold mt-4 mb-4">Editar orçamento</h1>

    <form action="{{ route('budgets.update', $budget) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm text-gray-600">Nome</label>
            <input name="name" value="{{ old('name', $budget->name) }}" required class="w-full rounded-lg border px-3 py-2" />
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="text-sm text-gray-600">Valor planejado</label>
                <input name="amount" type="number" step="0.01" value="{{ old('amount', $budget->amount) }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
            <div>
                <label class="text-sm text-gray-600">Data início</label>
                <input type="date" name="start_date" value="{{ old('start_date', $budget->start_date?->format('Y-m-d')) }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
            <div>
                <label class="text-sm text-gray-600">Data fim</label>
                <input type="date" name="end_date" value="{{ old('end_date', $budget->end_date?->format('Y-m-d')) }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
        </div>

        <div>
            <label class="text-sm text-gray-600">Categoria (opcional)</label>
            <select name="category_id" class="w-full rounded-lg border px-3 py-2">
                <option value="">Nenhuma</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (old('category_id', $budget->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $budget->is_active) ? 'checked' : '' }} class="rounded" />
                <span>Ativo</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button class="px-4 py-2 rounded-lg bg-brand-500 text-white">Salvar</button>
            <a href="{{ route('budgets.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection
