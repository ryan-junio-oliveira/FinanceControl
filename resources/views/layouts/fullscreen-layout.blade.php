<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | TailAdmin - Laravel Tailwind CSS Admin Dashboard Template</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Vanilla JS theme & sidebar store (used by fullscreen layout) -->
    <script>
        if (!window.TailAdmin) {
            (function () {
                window.TailAdmin = window.TailAdmin || {};

                TailAdmin.theme = {
                    theme: 'light',
                    init() {
                        const saved = localStorage.getItem('theme');
                        const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                        this.theme = saved || system;
                        this.update();
                    },
                    toggle() { this.theme = this.theme === 'light' ? 'dark' : 'light'; localStorage.setItem('theme', this.theme); this.update(); },
                    update() {
                        const html = document.documentElement;
                        const body = document.body;
                        if (this.theme === 'dark') { html.classList.add('dark'); body.classList.add('dark', 'bg-gray-900'); }
                        else { html.classList.remove('dark'); body.classList.remove('dark', 'bg-gray-900'); }
                    }
                };

                TailAdmin.sidebar = {
                    isExpanded: window.innerWidth >= 1280,
                    isMobileOpen: false,
                    isHovered: false,
                    init() { this.apply(); window.addEventListener('resize', () => { if (window.innerWidth < 1280) { this.setMobileOpen(false); this.isExpanded = false; } else { this.setMobileOpen(false); this.isExpanded = true; } this.apply(); }); },
                    apply() { const sidebarEl = document.getElementById('sidebar'); const overlays = document.querySelectorAll('.mobile-backdrop'); if (!sidebarEl) return; if (window.innerWidth >= 1280) { sidebarEl.classList.remove('-translate-x-full'); sidebarEl.classList.add('translate-x-0'); } else { if (this.isMobileOpen) { sidebarEl.classList.remove('-translate-x-full'); sidebarEl.classList.add('translate-x-0'); overlays.forEach(o=>{o.classList.remove('hidden'); o.classList.add('block')}); document.body.style.overflow = 'hidden'; } else { sidebarEl.classList.add('-translate-x-full'); sidebarEl.classList.remove('translate-x-0'); overlays.forEach(o=>{o.classList.remove('block'); o.classList.add('hidden')}); document.body.style.overflow = ''; } } },
                    toggleMobileOpen() { this.isMobileOpen = !this.isMobileOpen; this.apply(); },
                    setMobileOpen(val) { this.isMobileOpen = !!val; this.apply(); }
                };

                document.addEventListener('DOMContentLoaded', () => { TailAdmin.theme.init(); TailAdmin.sidebar.init(); setTimeout(()=>{ const pre = document.getElementById('preloader'); if (pre) pre.style.display = 'none'; }, 120); });
            })();
        }
    </script>

    <!-- Apply dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark', 'bg-gray-900');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark', 'bg-gray-900');
            }
        })();
    </script>
</head>

<body>

    {{-- preloader --}}
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white/80">
        <div class="w-14 h-14 rounded-full border-4 border-t-4 border-gray-600 border-t-gray-800 animate-spin" role="status" aria-label="Carregando"></div>
    </div>
    {{-- preloader end --}}

    @yield('content')

</body>

@stack('scripts')

</html>
