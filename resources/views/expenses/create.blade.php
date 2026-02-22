@extends('layouts.app')

@section('page_title', __('Nova Despesa'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Despesas'), 'url' => route('expenses.index')],
    ['label' => __('Nova Despesa')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-expense-form
            :categories="$categories"
            :credit-cards="$creditCards"
            action="{{ route('expenses.store') }}"
            button-label="{{ __('Salvar') }}"
            back-url="{{ route('expenses.index') }}" />
    </x-form-container>
</div>
@endsection
