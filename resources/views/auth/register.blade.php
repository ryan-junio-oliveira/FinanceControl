@extends('layouts.guest')

@section('title', 'Registrar')

@section('content')
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Finance<span class="text-brand-500">Control</span></h1>
            <p class="mt-2 text-sm text-gray-500">Crie sua conta gratuitamente</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6">
                <x-form-errors />

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <x-form-input name="username" label="Nome de usuário" :value="old('username')" placeholder="Seu nome de usuário" required />
                    <x-form-input name="email" label="E-mail" type="email" :value="old('email')" placeholder="seu@email.com" required />
                    <x-form-input name="organization_name" label="Nome da organização" :value="old('organization_name')" placeholder="Ex: Minha Empresa" required />

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <x-form-input name="password" label="Senha" type="password" placeholder="••••••••" required />
                        <x-form-input name="password_confirmation" label="Confirmar senha" type="password" placeholder="••••••••" required />
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-cyan-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-cyan-800 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                        Criar conta
                    </button>
                </form>
            </div>
            <div class="border-t border-gray-100 bg-gray-50/60 px-8 py-4 text-center text-sm text-gray-500">
                Já tem conta?
                <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 font-semibold transition-colors">Entrar</a>
            </div>
        </div>
    </div>
@endsection
