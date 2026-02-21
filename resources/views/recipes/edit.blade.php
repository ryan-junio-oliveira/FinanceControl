@extends('layouts.app')

@section('page_title', 'Editar Receita')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Receitas', 'url' => route('recipes.index')],
        ['label' => 'Editar Receita'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    {{-- header removed per request --}}
    <x-form-errors />

    <x-form-container>
        @include('recipes._form', [
            'action' => route('recipes.update', $recipe),
            'method' => 'PUT',
            'buttonLabel' => 'Atualizar',
            'backUrl' => route('recipes.index'),
            'categories' => $categories,
            'model' => $recipe,
        ])
    </x-form-container>
</div>
@endsection
