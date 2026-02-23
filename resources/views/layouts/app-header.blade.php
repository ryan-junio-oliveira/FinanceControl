<header
    id="app-header"
    class="fixed top-0 left-0 right-0 z-[100000] h-14 flex items-center px-4 shadow bg-brand-500 text-white">

    {{-- Left: brand (removed desktop hamburger to avoid duplicate) --}}
    <div class="flex items-center gap-3 min-w-[200px]">
        <div class="text-white font-bold text-lg tracking-tight select-none">
            Finance<span class="text-amber-400">Control</span> <span class="ml-1 text-xs font-medium bg-white/20 px-1.5 py-0.5 rounded">ERP</span>
        </div>
    </div>

    {{-- Center: page title --}}
    <div class="flex-1 text-white font-semibold text-sm pl-6">
        @yield('page_title')
    </div>

    {{-- Right: hamburger (mobile) + notifications + logout --}}
    <div class="flex items-center gap-3">
        <button data-sidebar-toggle="mobile"
                class="xl:hidden text-white hover:text-blue-200 transition p-1 rounded" aria-label="Menu">
            <i class="fa-solid fa-bars text-[20px]"></i>
        </button>

        {{-- notification bell --}}
        @auth
            @php
                $unread = auth()->user()->unreadNotifications()->count();
            @endphp
            <a href="{{ route('notifications') }}" class="relative text-white hover:text-blue-200 p-1 rounded">
                <i class="fa-solid fa-bell text-[18px]"></i>
                @if($unread > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-[2px] text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ $unread }}</span>
                @endif
            </a>
        @endauth

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button type="submit" variant="ghost" class="bg-white text-gray-700 p-2 rounded text-sm font-medium flex items-center gap-1 hover:text-cyan-600 transition cursor-pointer">
                Sair
                <i class="fa-solid fa-right-from-bracket text-[14px]"></i>
            </x-button>
        </form>
    </div>

</header>