@extends('layouts.app')

@section('title', 'Controles Mensais')

@section('content')
<div class="space-y-6">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Controles Mensais</h1>
            <p class="text-gray-500 text-sm mt-1">Acompanhe o desempenho financeiro mensal</p>
        </div>
        <a href="{{ route('monthly-controls.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-linear-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-sm hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
            <i class="fas fa-plus"></i>
            <span>Novo Controle</span>
        </a>
    </div>

    {{-- FILTERS --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                <select class="w-full bg-gray-50 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>2026</option>
                    <option>2025</option>
                    <option>2024</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                <select class="w-full bg-gray-50 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Todos</option>
                    <option>Janeiro</option>
                    <option>Fevereiro</option>
                    <option>Março</option>
                    <option>Abril</option>
                    <option>Maio</option>
                    <option>Junho</option>
                    <option>Julho</option>
                    <option>Agosto</option>
                    <option>Setembro</option>
                    <option>Outubro</option>
                    <option>Novembro</option>
                    <option>Dezembro</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium shadow-sm hover:bg-blue-700 hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                    <i class="fas fa-search mr-2"></i>Filtrar
                </button>
            </div>
        </div>
    </div>


    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Controles Financeiros</h3>
        </div>
        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 font-medium">{{ session('success') }}</div>
            @endif
            @if($controls->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mês/Ano</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($controls as $control)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ str_pad($control->month, 2, '0', STR_PAD_LEFT) }}/{{ $control->year }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('monthly-controls.edit', $control) }}" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-semibold shadow-sm hover:bg-blue-100 hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('monthly-controls.destroy', $control) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-semibold shadow-sm hover:bg-red-100 hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer" onclick="return confirm('Deseja remover este controle?')">
                                        <i class="fas fa-trash"></i> Remover
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $controls->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Nenhum controle mensal cadastrado ainda</p>
                    <a href="{{ route('monthly-controls.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-linear-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-sm hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <i class="fas fa-plus"></i>
                        <span>Criar primeiro controle</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection