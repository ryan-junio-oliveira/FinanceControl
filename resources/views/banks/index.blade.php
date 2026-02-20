@extends('layouts.app')

@section('page_title', 'Bancos')

@section('content')
<x-list-layout title="Bancos" subtitle="Gerencie seus bancos" create-url="{{ route('banks.create') }}" create-label="Novo banco" create-color="bg-cyan-800">

    <x-slot name="controls">
        <x-table-controls placeholder="Pesquisar bancos" :perPageOptions="[10,20,50,100]" />
    </x-slot>

    @php
        $columns = [
            ['label' => 'Nome', 'class' => 'text-left'],
            ['label' => 'Cor', 'class' => 'text-left'],
            ['label' => 'Ações', 'class' => 'text-right'],
        ];
    @endphp

    <div class="overflow-x-auto">
        <x-table compact :columns="$columns" id="banks-table" tbody-class="bg-white divide-y divide-gray-100">
            @forelse($banks as $bank)
                <tr class="group hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3.5 whitespace-nowrap text-sm font-medium text-gray-900">{{ $bank->name }}</td>
                    <td class="px-6 py-3.5 whitespace-nowrap">
                        <span class="inline-block w-6 h-6 rounded" style="background-color: {{ $bank->color ?? '#eee' }}"></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('banks.edit', $bank) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" aria-label="Editar banco {{ $bank->name }}">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </a>

                            <form action="{{ route('banks.destroy', $bank) }}" method="POST" onsubmit="return confirm('Remover banco?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" aria-label="Remover banco {{ $bank->name }}">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center">
                        <div class="mx-auto max-w-md">
                            <div class="text-3xl text-gray-300 mb-3">—</div>
                            <p class="text-sm text-gray-500">Nenhum banco cadastrado.</p>
                            <div class="mt-4">
                                <a href="{{ route('banks.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-cyan-800 text-white text-sm">Novo banco</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <x-slot name="pagination">
        @if($banks->hasPages())
            <div class="flex items-center justify-between border-t border-gray-600 px-6 py-3 server-pager banks">
                <p class="text-sm text-gray-500">
                    Exibindo <span class="font-medium text-gray-900">{{ $banks->firstItem() }}</span> a
                    <span class="font-medium text-gray-900">{{ $banks->lastItem() }}</span> de
                    <span class="font-medium text-gray-900">{{ $banks->total() }}</span> resultados
                </p>
                <div>
                    {{ $banks->links() }}
                </div>
            </div>
        @endif
    </x-slot>

</x-list-layout>
@endsection