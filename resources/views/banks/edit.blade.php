@extends('layouts.app')

@section('page_title', 'Editar Banco')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Editar Banco"
        subtitle="{{ $bank->name }}"
        back-url="{{ route('banks.index') }}"
        form-action="{{ route('banks.update', $bank) }}"
        cancel-url="{{ route('banks.index') }}"
        submit-label="Atualizar"
    >
        @method('PUT')
        <x-form-input name="name" label="Nome" :value="old('name', $bank->name)" required />

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cor <span class="text-xs text-gray-400">(hex)</span></label>
            <div class="flex items-center gap-3">
                <input type="color" name="color_picker" value="{{ old('color', $bank->color) }}"
                    oninput="document.getElementById('color_text_edit').value = this.value"
                    class="h-10 w-12 cursor-pointer rounded-lg border border-gray-200 p-1 shadow-sm" />
                <x-form-input name="color" id="color_text_edit" :value="old('color', $bank->color)" placeholder="#RRGGBB" class="flex-1" />
            </div>
        </div>
    </x-form-layout>
</div>
@endsection