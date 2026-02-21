@extends('layouts.app')

@section('page_title', 'Editar Cartão')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Cartões', 'url' => route('credit-cards.index')],
        ['label' => 'Editar Cartão'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('credit-cards._form', [
            'action' => route('credit-cards.update', ['id' => $creditCard->id()]),
            'method' => 'PUT',
            'buttonLabel' => 'Atualizar',
            'backUrl' => route('credit-cards.index'),
            'banks' => $banks,
            'model' => $creditCard,
        ])
    </x-form-container>
</div>
@endsection