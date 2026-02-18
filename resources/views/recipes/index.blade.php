@extends('layouts.app')

@section('title', 'Receitas')

@section('content')
<div class="space-y-6">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Receitas</h1>
            <p class="text-gray-500 text-sm mt-1">Gerencie todas as suas receitas</p>
        </div>
        <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-linear-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-sm hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
            <i class="fas fa-plus"></i>
            <span>Adicionar Receita</span>
        </a>
    </div>

    {{-- FILTERS --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                <select class="w-full bg-gray-50 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Este mês</option>
                    <option>Último mês</option>
                    <option>Últimos 3 meses</option>
                    <option>Este ano</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <select class="w-full bg-gray-50 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Todas</option>
                    <option>Salário</option>
                    <option>Freelance</option>
                    <option>Investimentos</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select class="w-full bg-gray-50 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Todos</option>
                    <option>Recebido</option>
                    <option>Pendente</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                    <i class="fas fa-search mr-2"></i>Filtrar
                </button>
                <!-- Adiciona cursor-pointer -->
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium cursor-pointer">
                </button>
            </div>
        </div>
    </div>


    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Lista de Receitas</h3>
        </div>
        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 font-medium">{{ session('success') }}</div>
            @endif
            @if(isset($recipes) && $recipes->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Recebida</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recipes as $recipe)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $recipe->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">R$ {{ number_format($recipe->amount, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $recipe->transaction_date ? $recipe->transaction_date->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $recipe->received ? 'Sim' : 'Não' }}</td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('recipes.edit', $recipe) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-semibold shadow-sm hover:bg-blue-100 hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-semibold shadow-sm hover:bg-red-100 hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer" onclick="return confirm('Deseja remover esta receita?')">
                                        <i class="fas fa-trash"></i> Remover
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $recipes->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Nenhuma receita cadastrada ainda</p>
                    <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-linear-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-sm hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <i class="fas fa-plus"></i>
                        <span>Adicionar primeira receita</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection