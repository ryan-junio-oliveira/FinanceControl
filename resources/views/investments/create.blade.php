@extends('layouts.app')

@section('page_title', __('Novo investimento'))

@section('content')
    <x-breadcrumbs :items="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Investimentos'), 'url' => route('investments.index')],
        ['label' => __('Novo investimento')],
    ]" />

    <x-form-section>
        <x-slot name="title">{{ __('Criar investimento') }}</x-slot>
        <x-slot name="description">{{ __('Registre uma nova aplicação financeira.') }}</x-slot>

        <x-slot name="form">
            <x-investment-form
                action="{{ route('investments.store') }}"
                button-label="{{ __('Salvar investimento') }}"
                back-url="{{ route('investments.index') }}"
            />
        </x-slot>
    </x-form-section>
@endsection