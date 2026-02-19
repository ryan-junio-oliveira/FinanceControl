@extends('layouts.app')

@section('page_title', 'Editar Controle Mensal')

@section('content')
<div class="max-w-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Controle Mensal</h1>
        <a href="{{ route('monthly-controls.index') }}" class="text-sm text-gray-500">Voltar</a>
    </div>

    <x-form-errors />

    <form action="{{ route('monthly-controls.update', $control) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium mb-1">Mês</label>
                <select name="month" required class="w-full rounded-lg border px-3 py-2">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ old('month', $control->month) == $m ? 'selected' : '' }}>{{ sprintf('%02d', $m) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Ano</label>
                <x-form-input name="year" type="number" min="2000" max="2100" :value="old('year', $control->year)" required />
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="btn-primary">Atualizar</button>
            <a href="{{ route('monthly-controls.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
