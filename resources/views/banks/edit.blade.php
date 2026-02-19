@extends('layouts.app')

@section('page_title', 'Editar Banco')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Banco</h1>
        <a href="{{ route('banks.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('banks.update', $bank) }}" method="POST" class="form-erp bg-white p-4 rounded-md shadow-sm space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <x-form-input name="name" :value="old('name', $bank->name)" required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Cor (hex)</label>
            <x-form-input name="color" :value="old('color', $bank->color)" class="w-32" placeholder="#RRGGBB" />
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Salvar</button>
            <a href="{{ route('banks.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection