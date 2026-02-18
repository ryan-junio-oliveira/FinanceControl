@extends('layouts.guest')

@section('title', 'Registrar')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-center mb-4 text-gray-900">Criar conta</h2>

        @if ($errors->any())
            <div class="mb-4 rounded-md border border-red-100 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <label class="block text-sm text-gray-700">
                Nome de usuário
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Seu nome de usuário" required
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2" />
            </label>

            <label class="block text-sm text-gray-700">
                E-mail
                <input type="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2" />
            </label>

            <label class="block text-sm text-gray-700">
                Nome da organização
                <input type="text" name="organization_name" value="{{ old('organization_name') }}"
                    placeholder="Ex: Minha Empresa" required
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2" />
            </label>

            <label class="block text-sm text-gray-700">
                Senha
                <input type="password" name="password" placeholder="••••••••" required
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2" />
            </label>

            <label class="block text-sm text-gray-700">
                Confirmar senha
                <input type="password" name="password_confirmation" placeholder="••••••••" required
                    class="mt-2 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2" />
            </label>

            <button type="submit" class="w-full py-2 rounded-md bg-blue-600 text-white font-semibold">Criar conta</button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-500">Já tem conta? <a href="{{ route('login') }}"
                class="text-blue-600 font-semibold">Entrar</a></p>
    </div>
@endsection
