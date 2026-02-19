@extends('layouts.app')

@section('page_title', 'Novo Controle Mensal')

@section('content')
<div class="max-w-lg">

    {{-- Page header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('monthly-controls.index') }}" class="flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-400 shadow-sm hover:bg-gray-50 hover:text-gray-600 transition-colors" aria-label="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Criar Controle Mensal</h1>
            <p class="text-xs text-gray-400 mt-0.5">Defina o mês e ano do período</p>
        </div>
    </div>

    <x-form-errors />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('monthly-controls.store') }}" method="POST" class="divide-y divide-gray-100">
            @csrf
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mês <span class="text-rose-500">*</span></label>
                        <select name="month" required class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>{{ sprintf('%02d', $m) }}</option>
                            @endfor
                        </select>
                    </div>
                    <x-form-input name="year" label="Ano" type="number" min="2000" max="2100" :value="old('year', now()->year)" required />
                </div>
            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                <button type="submit" class="btn-primary">Criar</button>
                <a href="{{ route('monthly-controls.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
