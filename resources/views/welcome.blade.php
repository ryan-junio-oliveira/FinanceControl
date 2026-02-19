@extends('layouts.fullscreen-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-brand-50 flex flex-col">

    {{-- Navbar --}}
    <header class="flex items-center justify-between px-6 py-4 sm:px-10">
        <span class="text-xl font-bold tracking-tight text-gray-900">Finance<span class="text-brand-500">Control</span></span>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Entrar</a>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-500 text-white text-sm font-semibold shadow-sm hover:bg-brand-600 transition-colors">Criar conta grátis</a>
        </div>
    </header>

    {{-- Hero --}}
    <main class="flex-1 flex flex-col items-center justify-center text-center px-6 py-20 sm:py-32">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-xs font-semibold mb-8">
            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
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
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-brand-500 text-white text-base font-semibold shadow-md hover:bg-brand-600 transition-colors">
                Começar gratuitamente
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl border border-gray-200 bg-white text-gray-700 text-base font-medium shadow-sm hover:bg-gray-50 transition-colors">
                Já tenho conta
            </a>
        </div>

        {{-- Features --}}
        <div class="mt-24 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto text-left">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 mb-4">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Despesas & Receitas</h3>
                <p class="text-sm text-gray-500">Registre todos os seus lançamentos e acompanhe o fluxo de caixa mês a mês.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600 mb-4">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Orçamentos</h3>
                <p class="text-sm text-gray-500">Defina limites por categoria e visualize o progresso do seu orçamento em tempo real.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 mb-4">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/></svg>
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
