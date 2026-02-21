@extends('layouts.app')

@section('page_title', __('Novo Cartão'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Cartões'), 'url' => route('credit-cards.index')],
    ['label' => __('Novo Cartão')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-credit-card-form
            :banks="$banks"
            action="{{ route('credit-cards.store') }}"
            button-label="{{ __('Salvar') }}"
            back-url="{{ route('credit-cards.index') }}" />
    </x-form-container>
</div>
@endsection