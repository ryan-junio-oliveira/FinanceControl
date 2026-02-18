<header
    id="app-header"
    class="fixed top-0 left-0 right-0 z-[100000] h-14 flex items-center px-4 shadow"
    style="background-color: #1590c0;"
    x-data="{}">

    {{-- Left: toggle + brand --}}
    <div class="flex items-center gap-3 min-w-[200px]">
        <button @click="$store.sidebar.toggleExpanded()"
                class="text-white hover:text-blue-200 transition p-1 rounded" aria-label="Toggle Sidebar">
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none">
                <rect width="20" height="2" rx="1" fill="currentColor"/>
                <rect y="7" width="20" height="2" rx="1" fill="currentColor"/>
                <rect y="14" width="20" height="2" rx="1" fill="currentColor"/>
            </svg>
        </button>
        <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg tracking-tight select-none">
            FinanceControl<span class="ml-1 text-xs font-medium bg-white/20 px-1.5 py-0.5 rounded">ERP</span>
        </a>
    </div>

    {{-- Center: page title --}}
    <div class="flex-1 text-white font-semibold text-sm pl-6">
        @yield('page_title')
    </div>

    {{-- Right: hamburger (mobile) + logout --}}
    <div class="flex items-center gap-3">
        <button @click="$store.sidebar.toggleMobileOpen()"
                class="xl:hidden text-white hover:text-blue-200 transition p-1 rounded" aria-label="Menu">
            <svg width="20" height="16" viewBox="0 0 20 16" fill="none">
                <rect width="20" height="2" rx="1" fill="currentColor"/>
                <rect y="7" width="20" height="2" rx="1" fill="currentColor"/>
                <rect y="14" width="20" height="2" rx="1" fill="currentColor"/>
            </svg>
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="text-white text-sm font-medium flex items-center gap-1 hover:text-blue-200 transition cursor-pointer">
                Sair
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </div>

</header>