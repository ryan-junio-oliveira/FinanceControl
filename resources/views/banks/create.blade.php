@extends('layouts.app')

@section('page_title', 'Novo Banco')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Novo Banco"
        subtitle="Preencha os dados do banco"
        back-url="{{ route('banks.index') }}"
        form-action="{{ route('banks.store') }}"
        cancel-url="{{ route('banks.index') }}"
        submit-label="Salvar"
    >
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
    </x-form-layout>
</div>
@endsection