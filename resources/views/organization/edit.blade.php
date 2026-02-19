@extends('layouts.app')

@section('page_title', 'Organização')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Organização</h1>
            <p class="text-sm text-gray-500">Configurações e membros</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-md bg-green-50 border border-green-100 p-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <form action="{{ route('organization.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="text-sm text-gray-600">Nome da organização</label>
                <input name="name" value="{{ old('name', $org->name) }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
            <div class="flex gap-3">
                <button class="px-4 py-2 rounded-lg bg-brand-500 text-white">Salvar</button>
                @if($org->isArchived())
                    <form action="{{ route('organization.unarchive') }}" method="POST">@csrf<button class="px-4 py-2 rounded-lg border">Restaurar</button></form>
                @else
                    <form action="{{ route('organization.archive') }}" method="POST">@csrf<button class="px-4 py-2 rounded-lg border text-rose-600" onclick="return confirm('Arquivar organização? Após 6 meses será excluída definitivamente.')">Arquivar</button></form>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-lg font-semibold mb-3">Convidar membro</h2>
        <form action="{{ route('organization.invite') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="text-sm text-gray-600">Usuário</label>
                <input name="username" value="{{ old('username') }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border px-3 py-2" />
            </div>
            <div class="flex items-end gap-2">
                <button class="px-4 py-2 rounded-lg bg-brand-500 text-white">Convidar</button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h2 class="text-lg font-semibold mb-3">Membros ({{ $members->count() }})</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Usuário</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $m)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $m->username }}</td>
                        <td class="px-4 py-3">{{ $m->email }}</td>
                        <td class="px-4 py-3">
                            @if($m->id !== auth()->id())
                            <form action="{{ route('organization.members.remove', $m) }}" method="POST" class="inline-block" onsubmit="return confirm('Remover membro?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600">Remover</button>
                            </form>
                            @else
                                <span class="text-gray-400">(você)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm text-sm text-gray-500">
        <strong>Arquivamento</strong>
        <p class="mt-2">Arquivar marca a organização como inativa; após 6 meses organizações arquivadas serão removidas permanentemente pelo sistema.</p>
    </div>
</div>
@endsection
