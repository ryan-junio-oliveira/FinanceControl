@extends('layouts.app')

@section('page_title', 'Controles Mensais')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Controles Mensais</h1>
    <a href="{{ route('monthly-controls.create') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white">Novo mês</a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
@endif

<table class="w-full text-sm rounded-lg overflow-hidden bg-white dark:bg-gray-800">
    <thead class="bg-gray-50 dark:bg-gray-900 text-left">
        <tr>
            <th class="px-4 py-3">Mês / Ano</th>
            <th class="px-4 py-3">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($controls as $control)
            <tr class="border-t">
                <td class="px-4 py-3">{{ sprintf('%02d / %d', $control->month, $control->year) }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('monthly-controls.edit', $control) }}" class="text-blue-600 mr-3">Editar</a>
                    <form action="{{ route('monthly-controls.destroy', $control) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover controle mensal?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Remover</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-4 py-6 text-center text-gray-500" colspan="2">Nenhum controle mensal encontrado.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $controls->links() }}
</div>
@endsection
