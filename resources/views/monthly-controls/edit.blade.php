@extends('layouts.app')

@section('title', 'Editar Controle Mensal')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Editar Controle Mensal</h1>
    <form method="POST" action="{{ route('monthly-controls.update', $control) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
            <select id="month" name="month" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                <option value="">Selecione o mês</option>
                @foreach([1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',7=>'Julho',8=>'Agosto',9=>'Setembro',10=>'Outubro',11=>'Novembro',12=>'Dezembro'] as $num => $nome)
                    <option value="{{ $num }}" {{ old('month', $control->month) == $num ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
            <input id="year" name="year" type="number" min="2000" max="2100" required value="{{ old('year', $control->year) }}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>
        <button type="submit" class="w-full py-3 rounded-xl bg-linear-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 active:scale-[0.99] transition-all duration-200 cursor-pointer">
            Atualizar Controle
        </button>
    </form>
</div>
@endsection
