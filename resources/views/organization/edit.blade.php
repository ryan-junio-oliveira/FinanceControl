@extends('layouts.app')

@section('page_title', 'Organização')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Page header --}}
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Organização</h1>
        <p class="text-sm text-gray-400 mt-0.5">Configurações e membros</p>
    </div>

    <x-form-errors />

    {{-- Organization name --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Dados da organização</h2>
        </div>
        <form action="{{ route('organization.update') }}" method="POST" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')
            <div class="p-6">
                <x-form-input name="name" label="Nome da organização" :value="old('name', $org->name)" required />
            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                <button type="submit" class="btn-primary">Salvar alterações</button>
            </div>
        </form>
    </div>

    {{-- Archive / Unarchive --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Zona de perigo</h2>
        </div>
        <div class="px-6 py-5 flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-gray-700">Arquivar organização</p>
                <p class="text-xs text-gray-400 mt-0.5">Marca a organização como inativa. Após 6 meses será removida permanentemente.</p>
            </div>
            @if($org->isArchived())
                <form action="{{ route('organization.unarchive') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm font-medium hover:bg-emerald-100 transition-colors">Restaurar</button>
                </form>
            @else
                <form action="{{ route('organization.archive') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Arquivar organização? Após 6 meses será excluída definitivamente.')" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 text-sm font-medium hover:bg-rose-100 transition-colors">Arquivar</button>
                </form>
            @endif
        </div>
    </div>

    {{-- Invite member --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Convidar membro</h2>
        </div>
        <form action="{{ route('organization.invite') }}" method="POST" class="divide-y divide-gray-100">
            @csrf
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-form-input name="username" label="Usuário" :value="old('username')" required />
                    <x-form-input name="email" label="Email" type="email" :value="old('email')" required />
                </div>
            </div>
            <div class="flex items-center gap-3 px-6 py-4 bg-gray-50/60">
                <button type="submit" class="btn-primary">Enviar convite</button>
            </div>
        </form>
    </div>

    {{-- Members --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-900">Membros</h2>
            <span class="inline-flex items-center justify-center h-5 min-w-[1.25rem] px-1.5 rounded-full bg-brand-50 text-brand-600 text-xs font-semibold">{{ $members->count() }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuário</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($members as $mem)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-brand-700 text-xs font-bold uppercase">{{ substr($mem->username, 0, 1) }}</span>
                                <span class="font-medium text-gray-900">{{ $mem->username }}</span>
                                @if($mem->id === auth()->id())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">você</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $mem->email }}</td>
                        <td class="px-6 py-4 text-right">
                            @if($mem->id !== auth()->id())
                            <form action="{{ route('organization.members.remove', $mem) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover membro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50 transition-colors opacity-0 group-hover:opacity-100" aria-label="Remover membro">
                                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/></svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
