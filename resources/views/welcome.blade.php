@extends('layouts.fullscreen-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-brand-50 flex flex-col">

    {{-- Navbar --}}
    <header class="flex items-center justify-between px-6 py-4 sm:px-10">
        <span class="text-xl font-bold tracking-tight text-gray-900">Finance<span class="text-brand-500">Control</span></span>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Entrar</a>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-cyan-800 text-white text-sm font-semibold shadow-sm hover:bg-cyan-800 transition-colors">Criar conta grátis</a>
        </div>
    </header>

    {{-- Hero --}}
    <main class="flex-1 flex flex-col items-center justify-center text-center px-6 py-20 sm:py-32">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-50 border border-brand-100 text-brand-600 text-xs font-semibold mb-8">
            <i class="fa-solid fa-chart-line text-[12px]"></i>
            Controle financeiro pessoal
        </div>

        <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 tracking-tight leading-none">
            Suas finanças<br>
            <span class="text-brand-500">sob controle</span>
        </h1>
        <p class="mt-6 text-lg text-gray-500 max-w-xl mx-auto">
            Gerencie despesas, receitas, orçamentos e cartões de crédito em um único lugar. Simples, rápido e organizado.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-cyan-800 text-white text-base font-semibold shadow-md hover:bg-cyan-800 transition-colors">
                Começar gratuitamente
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl border border-gray-200 bg-white text-gray-700 text-base font-medium shadow-sm hover:bg-gray-50 transition-colors">
                Já tenho conta
            </a>
        </div>

        {{-- Features --}}
        <div class="mt-24 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto text-left">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 mb-4">
                    <i class="fa-solid fa-list text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Despesas & Receitas</h3>
                <p class="text-sm text-gray-500">Registre todos os seus lançamentos e acompanhe o fluxo de caixa mês a mês.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600 mb-4">
                    <i class="fa-solid fa-calendar-days text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Orçamentos</h3>
                <p class="text-sm text-gray-500">Defina limites por categoria e visualize o progresso do seu orçamento em tempo real.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 text-brand-600 mb-4">
                    <i class="fa-solid fa-credit-card text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Cartões de crédito</h3>
                <p class="text-sm text-gray-500">Gerencie múltiplos cartões e vincule despesas diretamente a cada um.</p>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="text-center py-6 text-xs text-gray-400">
        &copy; {{ date('Y') }} FinanceControl &mdash; construído com Laravel + Tailwind CSS
    </footer>

</div>
@endsection
