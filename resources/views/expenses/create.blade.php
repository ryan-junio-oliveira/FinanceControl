@extends('layouts.app')

@section('page_title', 'Nova Despesa')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Despesas', 'url' => route('expenses.index')],
        ['label' => 'Nova Despesa'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('expenses._form', [
            'action' => route('expenses.store'),
            'method' => 'POST',
            'buttonLabel' => 'Salvar',
            'backUrl' => route('expenses.index'),
            'categories' => $categories,
            'controls' => $controls,
            'creditCards' => $creditCards,
            'model' => null,
        ])
    </x-form-container>
</div>
@endsection
