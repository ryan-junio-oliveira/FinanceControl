@extends('layouts.app')

@section('page_title', 'Novo Cartão')

@section('content')
@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Cartões', 'url' => route('credit-cards.index')],
        ['label' => 'Novo Cartão'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4">
    <x-form-errors />

    <x-form-container>
        @include('credit-cards._form', [
            'action' => route('credit-cards.store'),
            'method' => 'POST',
            'buttonLabel' => 'Salvar',
            'backUrl' => route('credit-cards.index'),
            'banks' => $banks,
            'model' => null,
        ])
    </x-form-container>
</div>
@endsection