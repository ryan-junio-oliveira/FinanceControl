@extends('layouts.app')

@section('page_title', __('Editar Receita'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Receitas'), 'url' => route('recipes.index')],
    ['label' => __('Editar Receita')],
]" />

<div class="max-w-5xl mx-auto px-4">
    {{-- header removed per request --}}
    <x-form-errors />

    <x-form-container>
        <x-recipe-form
            :categories="$categories"
            :model="$recipe"
            action="{{ route('recipes.update', $recipe) }}"
            method="PUT"
            button-label="{{ __('Atualizar') }}"
            back-url="{{ route('recipes.index') }}" />
    </x-form-container>
</div>
@endsection
