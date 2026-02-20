<header
    id="app-header"
    class="fixed top-0 left-0 right-0 z-[100000] h-14 flex items-center px-4 shadow bg-cyan-800 text-white">

    {{-- Left: brand (removed desktop hamburger to avoid duplicate) --}}
    <div class="flex items-center gap-3 min-w-[200px]">
        <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg tracking-tight select-none">
            Finance<span class="text-amber-400">Control</span> <span class="ml-1 text-xs font-medium bg-white/20 px-1.5 py-0.5 rounded">ERP</span>
        </a>
    </div>

    {{-- Center: page title --}}
    <div class="flex-1 text-white font-semibold text-sm pl-6">
        @yield('page_title')
    </div>

    {{-- Right: hamburger (mobile) + logout --}}
    <div class="flex items-center gap-3">
        <button data-sidebar-toggle="mobile"
                class="xl:hidden text-white hover:text-blue-200 transition p-1 rounded" aria-label="Menu">
            <i class="fa-solid fa-bars text-[20px]"></i>
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="bg-white text-gray-700 p-2 rounded text-sm font-medium flex items-center gap-1 hover:text-cyan-600 transition cursor-pointer">
                Sair
                <i class="fa-solid fa-right-from-bracket text-[14px]"></i>
            </button>
        </form>
    </div>

</header>