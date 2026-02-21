@extends('layouts.guest')

@section('title', __('Login'))

@section('content')
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Finance<span class="text-brand-500">Control</span></h1>
            <p class="mt-2 text-sm text-gray-500">{{ __('Acesse sua conta para continuar') }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6">
                <x-form-errors />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <x-form-input name="email" label="{{ __('E-mail') }}" type="email" :value="old('email')" placeholder="seu@email.com" required autofocus />
                    <x-form-input name="password" label="{{ __('Senha') }}" type="password" placeholder="••••••••" required />

                    <div class="flex items-center justify-between text-sm">
                        <x-form-checkbox name="remember" label="{{ __('Lembrar-me') }}" />
                        <a href="{{ route('password.request') }}" class="text-brand-500 hover:text-brand-600 font-medium transition-colors">{{ __('Esqueceu a senha?') }}</a>
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                        {{ __('Entrar') }}
                    </button>
                </form>
            </div>
            <div class="border-t border-gray-100 bg-gray-50/60 px-8 py-4 text-center text-sm text-gray-500">
                {{ __('Não tem conta?') }}
                <a href="{{ route('register') }}" class="text-brand-500 hover:text-brand-600 font-semibold transition-colors">{{ __('Criar agora') }}</a>
            </div>
        </div>
    </div>
@endsection
