@extends('layouts.app')

@section('page_title', 'Nova Receita')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Receitas', 'url' => route('recipes.index')],
        ['label' => 'Nova Receita'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    {{-- header removed per request --}}
    <x-form-errors />

    <x-form-container>
        @include('recipes._form', [
            'action' => route('recipes.store'),
            'method' => 'POST',
            'buttonLabel' => 'Salvar',
            'backUrl' => route('recipes.index'),
            'categories' => $categories,
            'model' => null,
        ])
    </x-form-container>
</div>
@endsection
