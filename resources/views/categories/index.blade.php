@extends('layouts.app')

@section('page_title', __('Categorias'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Categorias')],
]" />
<x-list-layout title="Categorias" subtitle="Gerencie categorias" create-url="{{ route('categories.create') }}" create-label="Nova categoria">

    <x-slot name="controls">
        <x-table-controls placeholder="{{ __('Pesquisar categorias') }}" :perPageOptions="[10,20,50,100]" />
    </x-slot>

    <x-form-errors />

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Nome') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Tipo') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Criado em') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium"><span class="sr-only">{{ __('Ações') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    @include('categories.partials.row', ['category' => $category])
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4">
                            <x-empty-state
                                :cols="4"
                                icon="tags"
                                title="{{ __('Nenhuma categoria encontrada.') }}"
                                button-url="{{ route('categories.create') }}"
                                button-label="{{ __('Nova categoria') }}"
                                button-class="bg-emerald-600" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
