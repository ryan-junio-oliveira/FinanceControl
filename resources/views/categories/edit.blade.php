@extends('layouts.app')

@section('page_title', 'Editar Categoria')

@section('content')
<div class="max-w-2xl mx-auto">

    <x-form-layout
        title="Editar Categoria"
        subtitle="{{ $category->name }}"
        back-url="{{ route('categories.index') }}"
        form-action="{{ route('categories.update', $category) }}"
        cancel-url="{{ route('categories.index') }}"
        submit-label="Atualizar"
    >
        @method('PUT')
        <x-form-input name="name" label="Nome" :value="old('name', $category->name)" required />

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-rose-500">*</span></label>
            <select name="type" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ (old('type', $category->type) === $key) ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </x-form-layout>
</div>
@endsection
