@extends('layouts.app')

@section('page_title', __('Editar investimento'))

@section('content')
    <x-breadcrumbs :items="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Investimentos'), 'url' => route('investments.index')],
        ['label' => __('Editar investimento')],
    ]" />

    <div class="max-w-5xl mx-auto px-4">
        <x-form-errors />

        <x-form-container>
            <x-investment-form
                :model="$investment"
                action="{{ route('investments.update', $investment) }}"
                method="PUT"
                button-label="{{ __('Atualizar investimento') }}"
                back-url="{{ route('investments.index') }}"
            />
        </x-form-container>
    </div>
@endsection