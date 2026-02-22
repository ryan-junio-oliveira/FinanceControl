@extends('layouts.app')

@section('page_title', __('Editar Despesa'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Despesas'), 'url' => route('expenses.index')],
    ['label' => __('Editar Despesa')],
]" />

<div class="max-w-5xl mx-auto px-4">
    
    <x-form-errors />

    <x-form-container>
        <x-expense-form
            :categories="$categories"
            :credit-cards="$creditCards"
            :model="$expense"
            action="{{ route('expenses.update', $expense) }}"
            method="PUT"
            button-label="{{ __('Atualizar') }}"
            back-url="{{ route('expenses.index') }}" />
    </x-form-container>
</div>
@endsection
