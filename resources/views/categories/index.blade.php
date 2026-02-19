@extends('layouts.app')

@section('page_title', 'Categorias')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Categorias</h1>
    <a href="{{ route('categories.create') }}" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Nova categoria</a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
        {{ $errors->first() }}
    </div>
@endif

<table class="w-full text-sm rounded-lg overflow-hidden bg-white">
    <thead class="bg-gray-50 text-left">
        <tr>
            <th class="px-4 py-3">Nome</th>
            <th class="px-4 py-3">Tipo</th>
            <th class="px-4 py-3">Criado em</th>
            <th class="px-4 py-3">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $category->name }}</td>
                <td class="px-4 py-3">{{ $category->type === 'recipe' ? 'Receita' : 'Despesa' }}</td>
                <td class="px-4 py-3">{{ $category->created_at->format('d/m/Y') }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 mr-3">Editar</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover categoria?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Remover</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-4 py-6 text-center text-gray-500" colspan="4">Nenhuma categoria encontrada.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $categories->links() }}</div>
@endsection
