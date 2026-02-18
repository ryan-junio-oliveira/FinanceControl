@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Painel Financeiro
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Visão geral das suas movimentações financeiras
            </p>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2.5 rounded-xl bg-white border border-gray-300 hover:bg-gray-50 transition text-sm font-medium text-gray-700 flex items-center gap-2 cursor-pointer">
                <i class="fas fa-download"></i>
                <span>Exportar</span>
            </button>

            <button class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-sm transition hover:shadow-lg hover:shadow-blue-500/50 flex items-center gap-2 cursor-pointer">
                <i class="fas fa-plus"></i>
                <span>Nova Transação</span>
            </button>
        </div>
    </div>

    {{-- KPI GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- SALDO --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Saldo Atual</p>
                    <h2 class="text-3xl font-bold mt-2 text-gray-900">
                        R$ 12.450,00
                    </h2>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-wallet text-lg"></i>
                </div>
            </div>

            <div class="flex items-center gap-1 text-sm">
                <span class="text-green-600 font-medium flex items-center gap-1">
                    <i class="fas fa-arrow-up text-xs"></i>
                    8.2%
                </span>
                <span class="text-gray-500">vs mês anterior</span>
            </div>
        </div>

        {{-- RECEITAS --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Receitas</p>
                    <h2 class="text-3xl font-bold mt-2 text-green-600">
                        R$ 8.300,00
                    </h2>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-arrow-trend-up text-lg"></i>
                </div>
            </div>

            <a href="{{ route('recipes.index') }}"
               class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1 cursor-pointer">
                Ver detalhes
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- DESPESAS --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Despesas</p>
                    <h2 class="text-3xl font-bold mt-2 text-red-600">
                        R$ 5.200,00
                    </h2>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-arrow-trend-down text-lg"></i>
                </div>
            </div>

            <a href="{{ route('expenses.index') }}"
               class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1 cursor-pointer">
                Ver detalhes
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- CONTROLE --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Execução Mensal</p>
                    <h2 class="text-3xl font-bold mt-2 text-gray-900">
                        72%
                    </h2>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-chart-pie text-lg"></i>
                </div>
            </div>

            <a href="{{ route('monthly-controls.index') }}"
               class="text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1 cursor-pointer">
                Ver relatório
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

    </div>

    {{-- GRID INFERIOR --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- GRÁFICO --}}
        <div class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg flex items-center gap-2 text-gray-900">
                    <i class="fas fa-chart-area text-blue-600"></i>
                    Fluxo de Caixa
                </h3>

                <select class="bg-gray-50 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
                    <option>Últimos 30 dias</option>
                    <option>Últimos 6 meses</option>
                    <option>Último ano</option>
                </select>
            </div>

            <div class="h-64 flex items-center justify-center text-gray-400 text-sm bg-gray-50 rounded-xl border border-gray-200">
                <div class="text-center">
                    <i class="fas fa-chart-line text-4xl mb-3 text-gray-300"></i>
                    <p>Gráfico de fluxo de caixa</p>
                    <p class="text-xs mt-1">(Chart.js / ApexCharts)</p>
                </div>
            </div>
        </div>

        {{-- TRANSAÇÕES --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <h3 class="font-bold text-lg mb-6 flex items-center gap-2 text-gray-900">
                <i class="fas fa-clock-rotate-left text-blue-600"></i>
                Últimas Transações
            </h3>

            <ul class="space-y-4">
                <li class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Salário</p>
                            <p class="text-xs text-gray-500">15/02/2026</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-semibold">+ R$ 5.000,00</span>
                </li>

                <li class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Aluguel</p>
                            <p class="text-xs text-gray-500">10/02/2026</p>
                        </div>
                    </div>
                    <span class="text-red-600 font-semibold">- R$ 1.200,00</span>
                </li>

                <li class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center text-red-600">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Supermercado</p>
                            <p class="text-xs text-gray-500">08/02/2026</p>
                        </div>
                    </div>
                    <span class="text-red-600 font-semibold">- R$ 450,00</span>
                </li>

                <li class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Freelance</p>
                            <p class="text-xs text-gray-500">05/02/2026</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-semibold">+ R$ 1.500,00</span>
                </li>
            </ul>

            <a href="#"
               class="mt-6 w-full inline-flex items-center justify-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                Ver todas as transações
                <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

    </div>

</div>
@endsection
