@extends('layouts.app')

@section('page_title', 'Categoria')

@section('content')
<div class="max-w-2xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('categories.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <i class="fa-solid fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">{{ $category->name }}</h1>
            <p class="text-xs text-gray-400 mt-0.5">Detalhes da categoria</p>
        </div>
        <div class="ml-auto">
            <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-cyan-800 text-white text-sm font-medium shadow-sm hover:bg-cyan-800 transition">Editar</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="divide-y divide-gray-100">
            <div class="flex items-center justify-between px-6 py-4">
                <span class="text-sm font-medium text-gray-500">Nome</span>
                <span class="text-sm font-semibold text-gray-900">{{ $category->name }}</span>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <span class="text-sm font-medium text-gray-500">Tipo</span>
                @if($category->type === 'recipe')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Receita
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>Despesa
                    </span>
                @endif
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <span class="text-sm font-medium text-gray-500">Criado em</span>
                <span class="text-sm text-gray-700">{{ $category->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection