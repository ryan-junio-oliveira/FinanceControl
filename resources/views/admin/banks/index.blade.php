@extends('layouts.app')

@section('page_title', __('Bancos'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Admin'), 'url' => route('admin.settings')],
    ['label' => __('Bancos')],
]" />

<x-list-layout title="Bancos" subtitle="Gerencie os bancos" create-url="{{ route('admin.banks.create') }}" create-label="Novo banco">

    <x-slot name="controls">
        <x-table-controls placeholder="{{ __('Pesquisar bancos') }}" :perPageOptions="[10,20,50,100]" />
    </x-slot>

    <x-form-errors />

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Nome') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium"><span class="sr-only">{{ __('Ações') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                    <tr class="group bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-heading">{{ $bank->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <x-link variant="ghost" href="{{ route('admin.banks.edit', $bank->id) }}" class="inline-flex items-center justify-center rounded-md text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 p-0" aria-label="{{ __('Editar banco :name', ['name' => $bank->name]) }}">
                                    <x-fa-icon name="pen" class="w-4 h-4 text-current" />
                                </x-link>
                                <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST" onsubmit="return confirm('{{ __('Remover banco?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="ghost" type="submit" class="inline-flex items-center justify-center rounded-md text-gray-500 hover:text-red-600 hover:bg-red-50 p-0" aria-label="{{ __('Remover banco :name', ['name' => $bank->name]) }}">
                                        <x-fa-icon name="trash" class="w-4 h-4 text-current" />
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4">
                            <x-empty-state
                                :cols="2"
                                icon="building-columns"
                                title="{{ __('Nenhum banco encontrado.') }}"
                                button-url="{{ route('admin.banks.create') }}"
                                button-label="{{ __('Novo banco') }}"
                                button-class="bg-emerald-600" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-list-layout>
@endsection
