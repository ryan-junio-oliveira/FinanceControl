@extends('layouts.guest')

@section('content')
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-8">
            <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-amber-100 text-amber-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Alterar senha</h1>
            <p class="mt-1 text-sm text-gray-500">É necessário redefinir sua senha para continuar.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form method="POST" action="{{ route('password.force.update') }}" class="divide-y divide-gray-100">
                @csrf
                <div class="px-8 py-6 space-y-5">
                    <x-form-errors />
                    <x-form-input name="password" label="Nova senha" type="password" required />
                    <x-form-input name="password_confirmation" label="Confirmar nova senha" type="password" required />
                </div>
                <div class="flex justify-end px-8 py-4 bg-gray-50/60">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 transition-colors">
                        Alterar senha
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection