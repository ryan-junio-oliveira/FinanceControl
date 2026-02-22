@extends('layouts.app')

@section('page_title', __('Editar investimento'))

@section('content')
    <x-breadcrumbs :items="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Investimentos'), 'url' => route('investments.index')],
        ['label' => __('Editar investimento')],
    ]" />

    <x-form-section>
        <x-slot name="title">{{ __('Editar investimento') }}</x-slot>
        <x-slot name="description">{{ __('Atualize os dados da aplicação financeira.') }}</x-slot>

        <x-slot name="form">
            <x-investment-form
                :model="$investment"
                action="{{ route('investments.update', $investment) }}"
                method="PUT"
                button-label="{{ __('Atualizar investimento') }}"
                back-url="{{ route('investments.index') }}"
            />
        </x-slot>
    </x-form-section>
@endsection