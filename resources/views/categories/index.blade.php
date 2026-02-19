@extends('layouts.app')

@section('page_title', 'Categorias')

@section('content')
<x-list-layout title="Categorias" subtitle="Gerencie categorias" create-url="{{ route('categories.create') }}" create-label="Nova categoria">

    <x-slot name="controls">
        <x-table-controls placeholder="Pesquisar categorias" :perPageOptions="[10,20,50,100]" />
    </x-slot>

    <x-form-errors />

    @php
        $columns = [
            ['label' => 'Nome', 'class' => 'text-left'],
            ['label' => 'Tipo', 'class' => 'text-left'],
            ['label' => 'Criado em', 'class' => 'text-left'],
            ['label' => 'Ações', 'class' => 'text-right'],
        ];
    @endphp

    <div class="overflow-x-auto">
        <x-table :columns="$columns" id="categories-table" tbody-class="bg-white divide-y divide-gray-100">
            @forelse($categories as $category)
                <tr class="group hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->type === 'recipe' ? 'Receita' : 'Despesa' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" aria-label="Editar categoria {{ $category->name }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M16.862 3.487a2.25 2.25 0 0 1 3.182 3.182L7.5 19.213l-4 1 1-4L16.862 3.487z" />
                                </svg>
                            </a>

                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Remover categoria?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" aria-label="Remover categoria {{ $category->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M3 6h18M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6M10 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="mx-auto max-w-md">
                            <div class="text-3xl text-gray-300 mb-3">—</div>
                            <p class="text-sm text-gray-500">Nenhuma categoria encontrada.</p>
                            <div class="mt-4">
                                <a href="{{ route('categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-emerald-600 text-white text-sm">Nova categoria</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <x-slot name="pagination">
        @if($categories->hasPages())
            <div class="flex items-center justify-between border-t border-gray-600 px-6 py-3 server-pager categories">
                <p class="text-sm text-gray-500">
                    Exibindo <span class="font-medium text-gray-900">{{ $categories->firstItem() }}</span> a
                    <span class="font-medium text-gray-900">{{ $categories->lastItem() }}</span> de
                    <span class="font-medium text-gray-900">{{ $categories->total() }}</span> resultados
                </p>
                <div>
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </x-slot>

</x-list-layout>
@endsection
