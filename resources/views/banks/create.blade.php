@extends('layouts.app')

@section('page_title', 'Novo Banco')

@section('content')
<div class="max-w-2xl">

    {{-- Page header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('banks.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Novo Banco</h1>
            <p class="text-xs text-gray-400 mt-0.5">Preencha os dados do banco</p>
        </div>
    </div>

    <x-form-errors />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('banks.store') }}" method="POST" class="divide-y divide-gray-100">
            @csrf
            <div class="p-6 space-y-5">
                <x-form-input name="name" label="Nome" :value="old('name')" required placeholder="Ex: Nubank, Bradesco" />

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cor <span class="text-xs text-gray-400">(hex)</span></label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color_picker" value="{{ old('color', '#8A05BE') }}"
                            oninput="document.getElementById('color_text').value = this.value"
                            class="h-10 w-12 cursor-pointer rounded-lg border border-gray-200 p-1 shadow-sm" />
                        <x-form-input name="color" id="color_text" :value="old('color', '#8A05BE')" placeholder="#RRGGBB" class="flex-1" />
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                <button type="submit" class="btn-primary">Salvar</button>
                <a href="{{ route('banks.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection