@extends('layouts.app')

@section('page_title', __('Editar Cartão'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Cartões'), 'url' => route('credit-cards.index')],
    ['label' => __('Editar Cartão')],
]" />

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        <x-credit-card-form
            :banks="$banks"
            :model="$card"
            action="{{ route('credit-cards.update', ['id' => $card->id()]) }}"
            method="PUT"
            button-label="{{ __('Atualizar') }}"
            back-url="{{ route('credit-cards.index') }}" />
    </x-form-container>
</div>
@endsection