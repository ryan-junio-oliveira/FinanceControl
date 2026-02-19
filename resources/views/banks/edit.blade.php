@extends('layouts.app')

@section('page_title', 'Editar Banco')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Banco</h1>
        <a href="{{ route('banks.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('banks.update', $bank) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nome</label>
            <input name="name" value="{{ old('name', $bank->name) }}" required class="w-full rounded-lg border px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Cor (hex)</label>
            <input name="color" value="{{ old('color', $bank->color) }}" class="w-32 rounded-lg border px-3 py-2" placeholder="#RRGGBB" />
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Salvar</button>
            <a href="{{ route('banks.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection