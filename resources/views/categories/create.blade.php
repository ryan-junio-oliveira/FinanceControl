@extends('layouts.app')

@section('page_title', 'Nova Categoria')

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Categorias'), 'url' => route('categories.index')],
    ['label' => __('Nova Categoria')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-category-form
            :types="$types"
            action="{{ route('categories.store') }}"
            button-label="{{ __('Salvar') }}"
            back-url="{{ route('categories.index') }}" />
    </x-form-container>
</div>
@endsection
