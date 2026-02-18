@php $user = auth()->user(); @endphp

<div class="relative">
    <button class="inline-flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
        <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-semibold text-gray-700 dark:text-gray-200">{{ strtoupper(substr($user->username ?? 'U', 0, 1)) }}</div>
        <div class="hidden xl:flex xl:flex-col text-left">
            <span class="text-sm font-medium">{{ $user->username ?? 'Usuário' }}</span>
            <span class="text-xs text-gray-500">{{ $user->email ?? '' }}</span>
        </div>
    </button>

    <!-- dropdown (placeholder) -->
    <div class="origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 hidden">
        <div class="py-1">
            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Painel</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200">Sair</button>
            </form>
        </div>
    </div>
</div>
