@extends('layouts.default')

@section('content')
<main class="relative min-h-screen">

    {{-- HEADER --}}
    <header class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-wallet text-white text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Finance<span class="text-blue-600">Control</span></h1>
            </div>

            <div class="hidden md:flex items-center gap-6">
                     <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition cursor-pointer">Entrar</a>
                     <a href="{{ route('register') }}"
                         class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-300 cursor-pointer">
                    Começar Grátis
                </a>
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 pt-20 pb-32 text-center">

        <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium mb-8">
            <i class="fas fa-sparkles"></i>
            <span>Controle financeiro profissional</span>
        </div>

        <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-tight mb-6 text-gray-900">
            Gerencie suas finanças
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                com inteligência
            </span>
        </h1>

        <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-12 leading-relaxed">
            Controle receitas e despesas mensais de forma organizada, com visão consolidada e relatórios estratégicos para sua empresa.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-20">
                <a href="{{ route('register') }}"
                    class="group inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-lg hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 cursor-pointer">
                <i class="fas fa-rocket"></i>
                <span>Começar Gratuitamente</span>
                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
            </a>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold text-lg hover:border-gray-400 hover:bg-gray-50 transition-all duration-300 cursor-pointer">
                <i class="fas fa-sign-in-alt"></i>
                <span>Fazer Login</span>
            </a>
        </div>

        {{-- FEATURES GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">

            <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl hover:border-blue-300 transition-all duration-300 cursor-pointer">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white text-2xl mb-5">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Análise Detalhada</h3>
                <p class="text-gray-600 leading-relaxed">
                    Relatórios completos com visão consolidada de receitas, despesas e saldo líquido por período.
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl hover:border-indigo-300 transition-all duration-300 cursor-pointer">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center text-white text-2xl mb-5">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-Organização</h3>
                <p class="text-gray-600 leading-relaxed">
                    Organize suas finanças por empresas ou departamentos com controles mensais independentes.
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl hover:border-green-300 transition-all duration-300 cursor-pointer">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white text-2xl mb-5">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Segurança Total</h3>
                <p class="text-gray-600 leading-relaxed">
                    Seus dados financeiros protegidos com criptografia e arquitetura segura de ponta a ponta.
                </p>
            </div>

        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-white">
                <div>
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <p class="text-blue-100">Gratuito para começar</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2"><i class="fas fa-infinity"></i></div>
                    <p class="text-blue-100">Transações ilimitadas</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <p class="text-blue-100">Acesso a qualquer hora</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="py-28">
        <div class="max-w-4xl mx-auto px-6 text-center">

            <div class="bg-gradient-to-br from-white to-blue-50 border border-gray-200 rounded-3xl p-12 shadow-xl">

                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">
                    Pronto para começar?
                </h2>

                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                    Crie sua conta gratuita agora e tenha controle total sobre suas finanças em minutos.
                </p>

                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-3 px-10 py-5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-lg hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-300 cursor-pointer">
                    <i class="fas fa-rocket"></i>
                    <span>Criar Conta Gratuita</span>
                    <i class="fas fa-arrow-right"></i>
                </a>

                <p class="text-sm text-gray-500 mt-6">Sem cartão de crédito • Sem compromisso • Começe em 2 minutos</p>

            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-gray-200 py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-white text-sm"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">Finance<span class="text-blue-600">Control</span></h1>
            </div>
            <p class="text-gray-500 text-sm">© {{ date('Y') }} FinanceControl. Todos os direitos reservados.</p>
        </div>
    </footer>

</main>
@endsection
