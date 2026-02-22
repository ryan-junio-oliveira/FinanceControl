@extends('layouts.guest')

@section('title', __('Login'))

@section('content')
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-8">
            <div class="text-3xl font-bold text-gray-900 tracking-tight">
                Finance<span class="text-amber-400">Control</span> <span class="ml-1 text-xs font-medium bg-gray-200 px-1.5 py-0.5 rounded">ERP</span>
            </div>
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
                        <x-link href="{{ route('password.request') }}" variant="ghost" class="text-brand-500 hover:text-brand-600 font-medium transition-colors">{{ __('Esqueceu a senha?') }}</x-link>
                    </div>

                    <x-button type="submit" variant="primary" class="w-full rounded-xl px-4 py-2.5 text-sm font-semibold">
                        {{ __('Entrar') }}
                    </x-button>
                </form>
            </div>
            <div class="border-t border-gray-100 bg-gray-50/60 px-8 py-4 text-center text-sm text-gray-500">
                {{ __('Não tem conta?') }}
                <x-link href="{{ route('register') }}" variant="ghost" class="text-brand-500 hover:text-brand-600 font-semibold transition-colors">{{ __('Criar agora') }}</x-link>
            </div>
        </div>
    </div>
@endsection
