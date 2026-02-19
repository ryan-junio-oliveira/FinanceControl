@extends('layouts.guest')

@section('title', 'Registrar')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white border border-gray-600 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-center mb-4 text-gray-900">Criar conta</h2>

        <x-form-errors />

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <x-form-input name="username" label="Nome de usuário" :value="old('username')" placeholder="Seu nome de usuário" required />

            <x-form-input name="email" label="E-mail" type="email" :value="old('email')" placeholder="seu@email.com" required />

            <x-form-input name="organization_name" label="Nome da organização" :value="old('organization_name')" placeholder="Ex: Minha Empresa" required />

            <x-form-input name="password" label="Senha" type="password" placeholder="••••••••" required />

            <x-form-input name="password_confirmation" label="Confirmar senha" type="password" placeholder="••••••••" required />

            <button type="submit" class="w-full py-2 rounded-md bg-blue-600 text-white font-semibold">Criar conta</button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-500">Já tem conta? <a href="{{ route('login') }}"
                class="text-blue-600 font-semibold">Entrar</a></p>
    </div>
@endsection
