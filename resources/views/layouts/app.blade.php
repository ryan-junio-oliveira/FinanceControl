<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | TailAdmin - Laravel Tailwind CSS Admin Dashboard Template</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Default header height CSS variable (updated dynamically by JS) -->
    <style>:root { --app-header-height: 56px; }</style>

    <!-- Vanilla JS theme & sidebar store (replaces Alpine.store) -->
    <script>
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
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.update();
                },
                update() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-gray-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-gray-900');
                    }
                }
            };

            TailAdmin.sidebar = {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,

                init() {
                    this.apply();

                    window.addEventListener('resize', () => {
                        if (window.innerWidth < 1280) {
                            this.setMobileOpen(false);
                            this.isExpanded = false;
                        } else {
                            this.setMobileOpen(false);
                            this.isExpanded = true;
                        }
                        this.apply();
                    });

                    // close on ESC
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && this.isMobileOpen) this.setMobileOpen(false);
                    });
                },

                apply() {
                    const sidebarEl = document.getElementById('sidebar');
                    const overlays = document.querySelectorAll('.mobile-backdrop');
                    if (!sidebarEl) return;

                    if (window.innerWidth >= 1280) {
                        sidebarEl.classList.remove('-translate-x-full');
                        sidebarEl.classList.add('translate-x-0');
                    } else {
                        if (this.isMobileOpen) {
                            sidebarEl.classList.remove('-translate-x-full');
                            sidebarEl.classList.add('translate-x-0');
                            overlays.forEach(o => { o.classList.remove('hidden'); o.classList.add('block'); });
                            document.body.style.overflow = 'hidden';
                        } else {
                            sidebarEl.classList.add('-translate-x-full');
                            sidebarEl.classList.remove('translate-x-0');
                            overlays.forEach(o => { o.classList.remove('block'); o.classList.add('hidden'); });
                            document.body.style.overflow = '';
                        }
                    }
                },

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                    this.apply();
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    this.apply();
                },

                setMobileOpen(val) {
                    this.isMobileOpen = !!val;
                    this.apply();
                },

                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) this.isHovered = !!val;
                }
            };

            document.addEventListener('DOMContentLoaded', () => {
                TailAdmin.theme.init();
                TailAdmin.sidebar.init();

                // hide preloader (replaces Alpine 'loaded')
                setTimeout(() => {
                    const pre = document.getElementById('preloader');
                    if (pre) pre.style.display = 'none';
                }, 120);

                // global click handlers: sidebar toggles and auto-close on mobile link click
                document.addEventListener('click', (ev) => {
                    const btn = ev.target.closest && ev.target.closest('[data-sidebar-toggle]');
                    if (btn) {
                        const mode = btn.getAttribute('data-sidebar-toggle');
                        if (mode === 'mobile') TailAdmin.sidebar.toggleMobileOpen();
                        if (mode === 'expand') TailAdmin.sidebar.toggleExpanded();
                    }

                    const a = ev.target.closest && ev.target.closest('#sidebar a');
                    if (a && window.innerWidth < 1280) TailAdmin.sidebar.setMobileOpen(false);

                    const backdrop = ev.target.closest && ev.target.closest('.mobile-backdrop');
                    if (backdrop) TailAdmin.sidebar.setMobileOpen(false);
                });
            });
        })();
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
    <x-common.preloader/>
    {{-- preloader end --}}

    <!-- app header (full width) -->
    @include('layouts.app-header')

    <script>
        /* expose header height so sidebar can be positioned below it */
        function setHeaderHeightVar() {
            const header = document.getElementById('app-header');
            if (header) {
                document.documentElement.style.setProperty('--app-header-height', header.offsetHeight + 'px');
            }
        }
        window.addEventListener('load', setHeaderHeightVar);
        window.addEventListener('resize', setHeaderHeightVar);
        setHeaderHeightVar();
    </script>

    <div class="min-h-screen xl:flex pt-[var(--app-header-height)]">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out lg:ml-[220px]">
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @yield('content')
            </div>
        </div>

    </div>

</body>

@stack('scripts')

</html>
