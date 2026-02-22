@extends('layouts.app')

@section('page_title', __('Investimento'))

@section('content')
    <x-breadcrumbs :items="[
        ['label' => __('Dashboard'), 'url' => route('dashboard')],
        ['label' => __('Investimentos'), 'url' => route('investments.index')],
        ['label' => $investment->name],
    ]" />

    <x-page-header>
        <x-slot name="title">{{ $investment->name }}</x-slot>
        <x-slot name="actions">
            <x-link href="{{ route('investments.edit', $investment) }}" variant="primary">
                {{ __('Editar') }}
            </x-link>
        </x-slot>
    </x-page-header>

    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <strong>{{ __('Valor:') }}</strong> R$ {{ number_format($investment->amount, 2, ',', '.') }}
                </div>
                <div>
                    <strong>{{ __('Data:') }}</strong>
                    @if ($investment->transaction_date)
                        {{ \Carbon\Carbon::parse($investment->transaction_date)->format('d/m/Y') }}
                    @else
                        —
                    @endif
                </div>
                <div>
                    <strong>{{ __('Fixo / recorrente:') }}</strong>
                    {{ $investment->fixed ? __('Sim') : __('Não') }}
                </div>
            </div>
        </div>
    </div>
@endsection