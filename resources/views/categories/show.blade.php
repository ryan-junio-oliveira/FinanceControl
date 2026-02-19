@extends('layouts.app')

@section('page_title', 'Categoria')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">{{ $category->name }}</h1>
        <a href="{{ route('categories.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="mb-3 text-sm text-gray-600">Tipo: <strong>{{ $category->type === 'recipe' ? 'Receita' : 'Despesa' }}</strong></div>
        <div class="mb-3 text-sm text-gray-600">Criado em: {{ $category->created_at->format('d/m/Y H:i') }}</div>
    </div>
</div>
@endsection