@extends('layouts.app')

@section('page_title', 'Editar Controle Mensal')

@section('content')
<div class="max-w-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Editar Controle Mensal</h1>
        <a href="{{ route('monthly-controls.index') }}" class="text-sm text-gray-500">Voltar</a>
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
                <input name="year" type="number" min="2000" max="2100" value="{{ old('year', $control->year) }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Atualizar</button>
            <a href="{{ route('monthly-controls.index') }}" class="px-4 py-2 rounded-lg border">Cancelar</a>
        </div>
    </form>
</div>
@endsection
