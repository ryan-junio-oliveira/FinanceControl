@extends('layouts.guest')

@section('title', 'Cadastro')

@section('content')
<div class="w-full max-w-md">

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">

        {{-- Logo --}}
        <div class="flex items-center justify-center gap-2 mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-wallet text-white text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Finance<span class="text-blue-600">Control</span></h1>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Criar conta</h2>
        <p class="text-center text-gray-500 mb-8">
            Comece a gerenciar suas finanças agora
        </p>

        {{-- Erros --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <ul class="space-y-1 flex-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Sucesso --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-600">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle mt-0.5"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Username --}}
            <div>
                <label for="username" class="block text-sm font-medium mb-2 text-gray-700">
                    Nome de usuário
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-user"></i>
                    </div>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autofocus
                        placeholder="seu_usuario"
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-300
                               text-gray-900 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition"
                    >
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium mb-2 text-gray-700">
                    E-mail
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="seu@email.com"
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-300
                               text-gray-900 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition"
                    >
                </div>
            </div>

            {{-- Organização --}}
            <div>
                <label for="organization_name" class="block text-sm font-medium mb-2 text-gray-700">
                    Nome da Organização
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-building"></i>
                    </div>
                    <input
                        id="organization_name"
                        type="text"
                        name="organization_name"
                        value="{{ old('organization_name') }}"
                        required
                        placeholder="Nome da sua empresa"
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-300
                               text-gray-900 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition"
                    >
                </div>
            </div>

            {{-- Senha --}}
            <div>
                <label for="password" class="block text-sm font-medium mb-2 text-gray-700">
                    Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-300
                               text-gray-900 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition"
                    >
                </div>
            </div>

            {{-- Confirmar Senha --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-2 text-gray-700">
                    Confirmar Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-300
                               text-gray-900 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition"
                    >
                </div>
            </div>

            {{-- Botão --}}
            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600
                       text-white font-semibold
                       hover:shadow-lg hover:shadow-blue-500/50
                       active:scale-[0.99]
                       transition-all duration-200"
            >
                Cadastrar
            </button>
        </form>
    </div>

    {{-- Login --}}
    <p class="mt-6 text-center text-gray-600 text-sm">
        Já tem conta?
        <a href="{{ route('login') }}"
           class="text-blue-600 hover:text-blue-700 font-semibold">
            Faça login
        </a>
    </p>
</div>
@endsection