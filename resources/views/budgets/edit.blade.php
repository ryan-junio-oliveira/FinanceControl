@extends('layouts.app')

@section('page_title', 'Editar Orçamento')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Orçamentos', 'url' => route('budgets.index')],
        ['label' => 'Editar Orçamento'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('budgets._form', [
            'action' => route('budgets.update', ['id' => $budget->id()]),
            'method' => 'PUT',
            'buttonLabel' => 'Atualizar',
            'backUrl' => route('budgets.index'),
            'categories' => $categories,
            'model' => $budget,
        ])
    </x-form-container>
</div>
@endsection
