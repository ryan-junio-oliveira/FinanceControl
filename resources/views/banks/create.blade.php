@extends('layouts.app')

@section('page_title', 'Novo Banco')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Novo Banco</h1>
        <a href="{{ route('banks.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('banks.store') }}" method="POST" class="form-erp bg-white p-4 rounded-md shadow-sm space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <x-form-input name="name" :value="old('name')" required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Cor (hex)</label>
            <x-form-input name="color" :value="old('color', '#8A05BE')" class="w-32" placeholder="#RRGGBB" />
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="btn-primary">Salvar</button>
            <a href="{{ route('banks.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection