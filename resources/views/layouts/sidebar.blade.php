
@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
    $currentPath = request()->path();
@endphp

<aside id="sidebar"
    class="fixed left-0 bg-white border-r border-gray-200 flex flex-col z-[99999] w-[220px] transition-transform duration-300"
    style="top: var(--app-header-height, 56px); height: calc(100vh - var(--app-header-height, 56px));"
    x-data="{
        openSubmenus: {},
        init() { this.autoOpen(); },
        autoOpen() {
            const p = '{{ $currentPath }}';
            @foreach ($menuGroups as $gi => $group)
                @foreach ($group['items'] as $ii => $item)
                    @if (isset($item['subItems']))
                        @foreach ($item['subItems'] as $sub)
                            if (p === '{{ ltrim($sub['path'], '/') }}' || window.location.pathname === '{{ $sub['path'] }}')
                                this.openSubmenus['{{ $gi }}-{{ $ii }}'] = true;
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        },
        toggle(key) { this.openSubmenus[key] = !this.openSubmenus[key]; },
        isOpen(key) { return !!this.openSubmenus[key]; },
        isActive(path) {
            return window.location.pathname === path || '{{ $currentPath }}' === path.replace(/^\//, '');
        }
    }"
    :class="{
        '-translate-x-full': !$store.sidebar.isMobileOpen && window.innerWidth < 1024,
        'translate-x-0':  $store.sidebar.isMobileOpen || window.innerWidth >= 1024
    }">

    {{-- User / Org --}}
    <div class="px-3 py-2.5 border-b border-gray-100 flex items-center gap-2 cursor-pointer hover:bg-gray-50 flex-shrink-0">
        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
             style="background-color:#1565C0;">
            {{ strtoupper(substr(auth()->user()->organization->name ?? auth()->user()->username ?? 'F', 0, 1)) }}
        </div>
        <span class="text-sm font-semibold text-gray-800 truncate flex-1 leading-tight">
            {{ auth()->user()->organization->name ?? auth()->user()->username ?? 'FinanceControl' }}
        </span>
        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24">
            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
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
                                <button @click="toggle('{{ $key }}')"
                                    class="w-full flex items-center gap-2 px-2 py-1.5 rounded text-sm font-medium transition-colors"
                                    :class="isOpen('{{ $key }}') ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-gray-100'">
                                    <span class="flex-shrink-0"
                                          :class="isOpen('{{ $key }}') ? 'text-blue-600' : 'text-gray-500'">
                                        {!! MenuHelper::getIconSvg($item['icon']) !!}
                                    </span>
                                    <span class="flex-1 text-left">{{ $item['name'] }}</span>
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200"
                                         :class="isOpen('{{ $key }}') ? 'rotate-180 text-blue-500' : 'text-gray-400'"
                                         fill="none" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <ul x-show="isOpen('{{ $key }}')"
                                    class="mt-0.5 ml-7 pl-2 border-l border-gray-200 space-y-0.5">
                                    @foreach ($item['subItems'] as $sub)
                                        <li>
                                            <a href="{{ $sub['path'] }}"
                                               class="block px-2 py-1.5 rounded text-sm transition-colors"
                                               :class="isActive('{{ $sub['path'] }}') ? 'text-blue-700 bg-blue-50 font-medium' : 'text-gray-600 hover:bg-gray-100'">
                                                {{ $sub['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a href="{{ $item['path'] }}"
                                   class="flex items-center gap-2 px-2 py-1.5 rounded text-sm font-medium transition-colors"
                                   :class="isActive('{{ $item['path'] }}') ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-gray-100'">
                                    <span class="flex-shrink-0"
                                          :class="isActive('{{ $item['path'] }}') ? 'text-blue-600' : 'text-gray-500'">
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

{{-- Mobile overlay --}}
<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     class="fixed inset-0 bg-gray-900/40 z-[99998] lg:hidden"
     style="display:none;"></div>