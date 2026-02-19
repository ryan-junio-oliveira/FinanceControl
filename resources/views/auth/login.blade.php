@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white border border-gray-600 rounded-lg p-6">
        <h1 class="text-center text-2xl font-semibold text-primary mb-6">Finance<span
                class="text-primary-accent">Control</span></h1>

        <x-form-errors />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-form-input name="email" label="E-mail" type="email" :value="old('email')" placeholder="seu@email.com" required autofocus />

            <x-form-input name="password" label="Senha" type="password" placeholder="••••••••" required />

            <div class="flex items-center justify-between text-sm">
                <x-form-checkbox name="remember" label="Lembrar-me" />

                <a href="{{ route('password.request') }}" class="text-blue-600">Esqueceu a senha?</a>
            </div>

            <button type="submit"
                class="w-full py-2 rounded-md bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold">
                Entrar
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-500">
            Não tem conta? <a href="{{ route('register') }}" class="text-blue-600 font-semibold">Criar agora</a>
        </p>
    </div>
@endsection
