@extends('layouts.app')

@section('page_title', 'Categoria')

@section('content')
<div class="max-w-2xl">

    <div class="flex items-center gap-3 mb-6">
        <x-button variant="secondary" href="{{ route('categories.index') }}" class="h-9 w-9 rounded-xl">
            <x-fa-icon name="arrow-left" class="h-4 w-4" />
        </a>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">{{ $category->name }}</h1>
            <p class="text-xs text-gray-400 mt-0.5">Detalhes da categoria</p>
        </div>
        <div class="ml-auto">
            <x-link variant="primary" href="{{ route('categories.edit', $category) }}">Editar</x-link>
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