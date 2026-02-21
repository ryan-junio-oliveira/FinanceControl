@extends('layouts.app')

@section('page_title', 'Editar Categoria')

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Categorias'), 'url' => route('categories.index')],
    ['label' => __('Editar Categoria')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-category-form
            :types="$types"
            :model="$category"
            action="{{ route('categories.update', $category) }}"
            method="PUT"
            button-label="{{ __('Atualizar') }}"
            back-url="{{ route('categories.index') }}" />
    </x-form-container>
</div>
@endsection
