@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md bg-white rounded shadow p-6">
    <h1 class="text-xl font-semibold mb-4">Alterar senha obrigatória</h1>



    <form method="POST" action="{{ route('password.force.update') }}">
        @csrf

        <div class="mb-4">
            <x-form-input name="password" label="Nova senha" type="password" required />
        </div>

        <div class="mb-4">
            <x-form-input name="password_confirmation" label="Confirmação da senha" type="password" required />
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Alterar senha</button>
        </div>
    </form>
</div>
@endsection