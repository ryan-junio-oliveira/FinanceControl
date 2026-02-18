@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-6">
        <h1 class="text-center text-2xl font-semibold text-primary mb-6">Finance<span
                class="text-primary-accent">Control</span></h1>

        @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-100 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <label class="block text-sm text-gray-700">
                E-mail
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="seu@email.com"
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </label>

            <label class="block text-sm text-gray-700">
                Senha
                <input id="password" type="password" name="password" required placeholder="••••••••"
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </label>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    Lembrar-me
                </label>

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
