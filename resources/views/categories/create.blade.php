@extends('layouts.app')

@section('page_title', 'Nova Categoria')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Nova Categoria</h1>
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-500">Voltar</a>
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

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <input name="name" value="{{ old('name') }}" required class="w-full rounded-lg border px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Tipo</label>
            <select name="type" required class="w-full rounded-lg border px-3 py-2">
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
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
