@extends('layouts.app')

@section('page_title', 'Editar Despesa')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Despesas', 'url' => route('expenses.index')],
        ['label' => 'Editar Despesa'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    
    <x-form-errors />

    <x-form-container>
        @include('expenses._form', [
            'action' => route('expenses.update', $expense),
            'method' => 'PUT',
            'buttonLabel' => 'Atualizar',
            'backUrl' => route('expenses.index'),
            'categories' => $categories,
            'controls' => $controls,
            'creditCards' => $creditCards,
            'model' => $expense,
        ])
    </x-form-container>
</div>
@endsection
