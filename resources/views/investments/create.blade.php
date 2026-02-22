@extends('layouts.app')

@section('page_title', __('Novo investimento'))

@section('content')
    <x-breadcrumbs :items="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Investimentos'), 'url' => route('investments.index')],
        ['label' => __('Novo investimento')],
    ]" />

    <div class="max-w-5xl mx-auto px-4">
        <x-form-errors />

        <x-form-container>
            <x-investment-form
                action="{{ route('investments.store') }}"
                button-label="{{ __('Salvar investimento') }}"
                back-url="{{ route('investments.index') }}"
            />
        </x-form-container>
    </div>
@endsection