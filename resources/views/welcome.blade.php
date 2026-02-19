@extends('layouts.fullscreen-layout')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center gap-6">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">FinanceControl</h1>
        <p class="mt-2 text-gray-600">Controle simples e rápido das suas finanças mensais.</p>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('login') }}" class="px-6 py-3 rounded-lg bg-blue-600 text-white font-semibold">Entrar</a>
        <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg border border-gray-600 text-gray-700">Criar conta</a>
    </div>

    <div class="mt-6 text-sm text-gray-500">Demo básica construída com Tailwind + Laravel</div>
</div>
@endsection
