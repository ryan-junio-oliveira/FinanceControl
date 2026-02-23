@extends('layouts.app')

@section('page_title', __('Editar Banco'))

@section('content')
<x-breadcrumbs :items="[
    ['label' => __('Dashboard'), 'url' => route('dashboard')],
    ['label' => __('Admin'), 'url' => route('admin.settings')],
    ['label' => __('Bancos'), 'url' => route('admin.banks.index')],
    ['label' => __('Editar banco')],
]" />

<x-card>
    <form action="{{ route('admin.banks.update', $bank->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.banks._form')

        <div class="mt-4">
            <x-button>{{ __('Atualizar') }}</x-button>
            <x-link href="{{ route('admin.banks.index') }}" variant="secondary">{{ __('Cancelar') }}</x-link>
        </div>
    </form>
</x-card>
@endsection
