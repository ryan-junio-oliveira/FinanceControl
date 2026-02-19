@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
    // prefer route names for active checks when available
    $currentRoute = request()->route() ? request()->route()->getName() : null;

    // determine which submenu groups should be open on initial render
    $openKeys = [];
    foreach ($menuGroups as $gi => $group) {
        foreach ($group['items'] as $ii => $item) {
            if (isset($item['subItems'])) {
                foreach ($item['subItems'] as $sub) {
                    // open submenu only when a route is provided and it matches the current route
                    if (isset($sub['route']) && $currentRoute && request()->routeIs($sub['route'])) {
                        $openKeys[] = "{$gi}-{$ii}";
                    }
                }
            }
        }
    }
@endphp

<aside id="sidebar"
    class="fixed left-0 bg-white border-r border-gray-200 flex flex-col z-[99999] w-[220px] transition-transform duration-300 -translate-x-full lg:translate-x-0"
    style="top: var(--app-header-height, 56px); height: calc(100vh - var(--app-header-height, 56px));">

    {{-- User / Org (dropdown) --}}
    <div class="relative px-3 py-2.5 border-b border-gray-100 flex-shrink-0">
        <button type="button" id="org-toggle"
            class="w-full flex items-center gap-2 cursor-pointer hover:bg-gray-50 rounded px-1 py-1">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                style="background-color:#1565C0;">
                {{ strtoupper(substr(auth()->user()->organization->name ?? (auth()->user()->username ?? 'F'), 0, 1)) }}
            </div>
            <span class="text-sm font-semibold text-gray-800 truncate flex-1 leading-tight">
                {{ auth()->user()->organization->name ?? (auth()->user()->username ?? 'FinanceControl') }}
            </span>
            <i id="org-chevron"
                class="fa-solid fa-chevron-down text-gray-400 text-[14px] flex-shrink-0 transition-transform duration-150"></i>
        </button>

        {{-- Dropdown menu (hidden by default) --}}
        <div id="org-dropdown"
            class="hidden mt-2 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden text-sm z-50">
            <div class="px-4 py-3 border-b border-gray-100">
                <div class="font-semibold text-gray-800 truncate">
                    {{ auth()->user()->organization->name ?? (auth()->user()->username ?? 'FinanceControl') }}</div>
                @if (optional(auth()->user()->organization)->isArchived())
                    <div class="text-xs text-red-600 mt-1">Arquivada</div>
                @else
                    <div class="text-xs text-gray-500 mt-1">Organização ativa</div>
                @endif
            </div>

            <div class="px-2 py-2">
                <a href="{{ route('organization.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-50">Configurar
                    organização</a>
                <a href="{{ route('organization.edit') }}#members"
                    class="block px-3 py-2 rounded hover:bg-gray-50">Membros</a>
            </div>

            <div class="px-2 py-2 border-t border-gray-100">
                @if (optional(auth()->user()->organization)->isArchived())
                    <form action="{{ route('organization.unarchive') }}" method="POST"
                        onsubmit="return confirm('Restaurar organização?');">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 py-2 rounded text-sm hover:bg-gray-50">Restaurar
                            organização</button>
                    </form>
                @else
                    <form action="{{ route('organization.archive') }}" method="POST"
                        onsubmit="return confirm('Arquivar organização? Ela será excluída automaticamente após 6 meses.');">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-3 py-2 rounded text-sm hover:bg-gray-50">Arquivar
                            organização</button>
                    </form>
                @endif

                <form action="{{ route('organization.destroy') }}" method="POST"
                    onsubmit="return confirm('Remover organização permanentemente? Esta ação não pode ser desfeita.');"
                    class="mt-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full text-left px-3 py-2 rounded text-sm text-red-600 hover:bg-gray-50">Remover
                        organização</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-2 px-2">
        @foreach ($menuGroups as $gi => $group)
            <div class="mb-3">
                <p class="px-2 mb-1 text-[10px] font-semibold uppercase tracking-wider text-gray-400 select-none">
                    {{ $group['title'] }}
                </p>

                <ul class="space-y-0.5">
                    @foreach ($group['items'] as $ii => $item)
                        @php $key = $gi . '-' . $ii; @endphp
                        <li>
                            @if (isset($item['subItems']))
                                @php $isOpen = in_array($key, $openKeys); @endphp
                                <button type="button" data-submenu-key="{{ $key }}"
                                    class="submenu-toggle w-full flex items-center gap-2 px-2 py-1.5 rounded text-sm font-medium transition-colors {{ $isOpen ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <span class="flex-shrink-0 {{ $isOpen ? 'text-blue-600' : 'text-gray-500' }}">
                                        {!! MenuHelper::getIconSvg($item['icon']) !!}
                                    </span>
                                    <span class="flex-1 text-left">{{ $item['name'] }}</span>
                                    <i
                                        class="fa-solid fa-chevron-down flex-shrink-0 transition-transform duration-200 text-[14px] {{ $isOpen ? 'rotate-180 text-blue-500' : 'text-gray-400' }}"></i>
                                </button>
                                <ul id="submenu-{{ $key }}"
                                    class="mt-0.5 ml-7 pl-2 border-l border-gray-200 space-y-0.5 {{ $isOpen ? '' : 'hidden' }}">
                                    @foreach ($item['subItems'] as $sub)
                                        <li>
                                            @php
                                                $isActive = false;
                                                if (isset($sub['route'])) {
                                                    $isActive = request()->routeIs($sub['route']);
                                                } else {
                                                    // no route provided — consider not active (route-based matching only)
                                                    $isActive = false;
                                                }
                                            @endphp
                                            <a href="{{ $sub['path'] }}"
                                                class="block px-2 py-1.5 rounded text-sm transition-colors {{ $isActive ? 'text-blue-700 bg-blue-50 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                                                {{ $sub['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @php
                                    $isActiveTop = false;
                                    if (isset($item['route'])) {
                                        $isActiveTop = request()->routeIs($item['route']);
                                    } else {
                                        // prefer route-based matching only
                                        $isActiveTop = false;
                                    }
                                @endphp
                                <a href="{{ $item['path'] }}"
                                    class="flex items-center gap-2 px-2 py-1.5 rounded text-sm font-medium transition-colors {{ $isActiveTop ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <span class="flex-shrink-0 {{ $isActiveTop ? 'text-blue-600' : 'text-gray-500' }}">
                                        {!! MenuHelper::getIconSvg($item['icon']) !!}
                                    </span>
                                    {{ $item['name'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>
</aside>

<script>
    // submenu toggle (vanilla JS)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest && e.target.closest('.submenu-toggle');
        if (!btn) return;
        const key = btn.getAttribute('data-submenu-key');
        const submenu = document.getElementById('submenu-' + key);
        // safety: if submenu element is missing, bail out (prevents runtime errors)
        if (!submenu) return;
        const chevron = btn.querySelector('.fa-chevron-down');
        const isHidden = submenu.classList.contains('hidden');

        if (isHidden) {
            submenu.classList.remove('hidden');
            btn.classList.remove('text-gray-700');
            btn.classList.add('text-blue-700', 'bg-blue-50');
            if (chevron) {
                chevron.classList.add('rotate-180', 'text-blue-500');
                chevron.classList.remove('text-gray-400');
            }
        } else {
            submenu.classList.add('hidden');
            btn.classList.remove('text-blue-700', 'bg-blue-50');
            btn.classList.add('text-gray-700');
            if (chevron) {
                chevron.classList.remove('rotate-180', 'text-blue-500');
                chevron.classList.add('text-gray-400');
            }
        }
    });

    // organization dropdown toggle (sidebar)
    (function() {
        const toggle = document.getElementById('org-toggle');
        const menu = document.getElementById('org-dropdown');
        const chev = document.getElementById('org-chevron');
        if (!toggle || !menu) return;

        const closeMenu = () => {
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                chev && chev.classList.remove('rotate-180');
            }
        };

        toggle.addEventListener('click', function(ev) {
            ev.stopPropagation();
            menu.classList.toggle('hidden');
            chev && chev.classList.toggle('rotate-180');
        });

        // close when clicking outside
        document.addEventListener('click', function(ev) {
            const inside = ev.target.closest && ev.target.closest('#org-dropdown');
            const isToggle = ev.target.closest && ev.target.closest('#org-toggle');
            if (!inside && !isToggle) closeMenu();
        });

        // close on Escape
        document.addEventListener('keydown', function(ev) {
            if (ev.key === 'Escape') closeMenu();
        });
    })();

    // close mobile sidebar when a navigation link is clicked (delegate)
    document.getElementById('sidebar')?.addEventListener('click', function(e) {
        const a = e.target.closest && e.target.closest('a');
        if (!a) return;
        if (window.innerWidth < 1280) {
            TailAdmin && TailAdmin.sidebar && TailAdmin.sidebar.setMobileOpen(false);
        }
    });
</script>
