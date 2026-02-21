@extends('layouts.app')

@section('page_title', 'Editar Categoria')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Categorias', 'url' => route('categories.index')],
        ['label' => 'Editar Categoria'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('categories._form', [
            'action' => route('categories.update', $category),
            'method' => 'PUT',
            'buttonLabel' => 'Atualizar',
            'backUrl' => route('categories.index'),
            'types' => $types,
            'model' => $category,
        ])
    </x-form-container>
</div>
@endsection
