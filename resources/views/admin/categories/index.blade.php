@extends('layouts.app')

@section('page_title', __('Categorias (admin)'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Admin'), 'url' => route('admin.settings')],
    ['label' => __('Categorias')],
]" />

<x-list-layout title="Categorias" subtitle="Gerencie categorias de qualquer organização" create-url="{{ route('admin.categories.create') }}" create-label="Nova categoria">

    <x-slot name="controls">
        <div class="flex flex-wrap gap-2">
            <x-table-controls placeholder="{{ __('Pesquisar categorias') }}" :perPageOptions="[10,20,50,100]" />

            <form method="GET" action="" class="flex items-center gap-2">
                <x-form-select name="org" :options="collect($organizations)->map(fn($o) => ['value' => $o->id, 'label' => $o->name])->all()" :value="request('org')" placeholder="{{ __('Todas organizações') }}" />
            </form>
        </div>
    </x-slot>

    <x-form-errors />

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Nome') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Tipo') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Organização') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium">{{ __('Criado em') }}</th>
                    <th scope="col" class="px-6 py-3 font-medium"><span class="sr-only">{{ __('Ações') }}</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    @include('admin.categories.partials.row', ['category' => $category])
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4">
                            <x-empty-state
                                :cols="5"
                                icon="tags"
                                title="{{ __('Nenhuma categoria encontrada.') }}"
                                button-url="{{ route('admin.categories.create') }}"
                                button-label="{{ __('Nova categoria') }}"
                                button-class="bg-emerald-600" />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->appends(request()->query())->links() }}

</x-list-layout>
@endsection
