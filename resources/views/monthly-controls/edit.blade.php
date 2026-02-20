@extends('layouts.app')

@section('page_title', 'Editar Controle Mensal')

@section('content')
<div class="max-w-lg mx-auto">

    <x-form-layout
        title="Editar Controle Mensal"
        subtitle="{{ sprintf('%02d / %d', $control->month, $control->year) }}"
        back-url="{{ route('monthly-controls.index') }}"
        form-action="{{ route('monthly-controls.update', $control) }}"
        cancel-url="{{ route('monthly-controls.index') }}"
        submit-label="Atualizar"
        width-class="max-w-lg"
    >
        @method('PUT')
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mês <span class="text-rose-500">*</span></label>
                <select name="month" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ old('month', $control->month) == $m ? 'selected' : '' }}>{{ sprintf('%02d', $m) }}</option>
                    @endfor
                </select>
            </div>
            <x-form-input name="year" label="Ano" type="number" min="2000" max="2100" :value="old('year', $control->year)" required />
        </div>
    </x-form-layout>
</div>
@endsection
