@extends('layouts.app')

@section('page_title', 'Editar Categoria')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Categoria</h1>
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <x-form-input name="name" :value="old('name', $category->name)" required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Tipo</label>
            <select name="type" required class="w-full rounded-lg border px-3 py-2">
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ (old('type', $category->type) === $key) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Salvar</button>
            <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection
