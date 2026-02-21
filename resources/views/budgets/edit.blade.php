@extends('layouts.app')

@section('page_title', __('Editar Orçamento'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Orçamentos'), 'url' => route('budgets.index')],
    ['label' => __('Editar Orçamento')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-budget-form
            :categories="$categories"
            :model="$budget"
            action="{{ route('budgets.update', ['id' => $budget->id()]) }}"
            method="PUT"
            button-label="{{ __('Atualizar') }}"
            back-url="{{ route('budgets.index') }}" />
    </x-form-container>
</div>
@endsection
