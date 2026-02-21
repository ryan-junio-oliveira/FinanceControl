@extends('layouts.app')

@section('page_title', 'Nova Categoria')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Categorias', 'url' => route('categories.index')],
        ['label' => 'Nova Categoria'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('categories._form', [
            'action' => route('categories.store'),
            'method' => 'POST',
            'buttonLabel' => 'Salvar',
            'backUrl' => route('categories.index'),
            'types' => $types,
            'model' => null,
        ])
    </x-form-container>
</div>
@endsection
