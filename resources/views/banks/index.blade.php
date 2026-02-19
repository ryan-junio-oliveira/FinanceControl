@extends('layouts.app')

@section('page_title', 'Bancos')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold">Bancos</h1>
        <a href="{{ route('banks.create') }}" class="px-4 py-2 rounded-lg bg-brand-500 text-white">Novo banco</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Nome</th>
                    <th class="px-4 py-3">Cor</th>
                    <th class="px-4 py-3">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $bank->name }}</td>
                        <td class="px-4 py-3"><span class="inline-block w-6 h-6 rounded" style="background-color: {{ $bank->color ?? '#eee' }}"></span></td>
                        <td class="px-4 py-3">
                            <a href="{{ route('banks.edit', $bank) }}" class="text-blue-600 mr-3">Editar</a>
                            <form action="{{ route('banks.destroy', $bank) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover banco?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-center text-gray-500" colspan="3">Nenhum banco cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $banks->links() }}</div>
</div>
@endsection