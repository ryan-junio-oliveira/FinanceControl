@extends('layouts.app')

@section('page_title', __('Novo Orçamento'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Orçamentos'), 'url' => route('budgets.index')],
    ['label' => __('Novo Orçamento')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-budget-form
            :categories="$categories"
            action="{{ route('budgets.store') }}"
            button-label="{{ __('Salvar') }}"
            back-url="{{ route('budgets.index') }}" />
    </x-form-container>
</div>
@endsection
