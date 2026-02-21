@extends('layouts.app')

@section('page_title', 'Novo Orçamento')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Orçamentos', 'url' => route('budgets.index')],
        ['label' => 'Novo Orçamento'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('budgets._form', [
            'action' => route('budgets.store'),
            'method' => 'POST',
            'buttonLabel' => 'Salvar',
            'backUrl' => route('budgets.index'),
            'categories' => $categories,
            'model' => null,
        ])
    </x-form-container>
</div>
@endsection
