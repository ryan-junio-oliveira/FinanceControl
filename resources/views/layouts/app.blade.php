<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | FinanceControl</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --app-header-height: 56px;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50">

    {{-- Preloader --}}
    <x-preloader />

    {{-- Header --}}
    @include('layouts.app-header')

    <div class="min-h-screen xl:flex pt-[var(--app-header-height)]">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <x-application.alerts.container />

        <main class="flex-1 transition-all duration-300 lg:ml-[220px]">
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                {{-- global breadcrumbs (pages must provide $breadcrumbs manually) --}}
                @if (!empty($breadcrumbs) && is_array($breadcrumbs))
                    <x-breadcrumbs :items="$breadcrumbs" />
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    {{-- Core UI Controller --}}
    <script>
        (() => {
            const UI = {

                sidebar: {
                    expanded: window.innerWidth >= 1280,
                    mobileOpen: false,

                    apply() {
                        const sidebar = document.getElementById('sidebar');
                        const overlays = document.querySelectorAll('.mobile-backdrop');
                        if (!sidebar) return;

                        const isDesktop = window.innerWidth >= 1280;

                        if (isDesktop) {
                            sidebar.classList.remove('-translate-x-full');
                            sidebar.classList.add('translate-x-0');
                            this.mobileOpen = false;
                            document.body.style.overflow = '';
                            return;
                        }

                        sidebar.classList.toggle('translate-x-0', this.mobileOpen);
                        sidebar.classList.toggle('-translate-x-full', !this.mobileOpen);

                        overlays.forEach(o => {
                            o.classList.toggle('hidden', !this.mobileOpen);
                            o.classList.toggle('block', this.mobileOpen);
                        });

                        document.body.style.overflow = this.mobileOpen ? 'hidden' : '';
                    },

                    toggleMobile() {
                        this.mobileOpen = !this.mobileOpen;
                        this.apply();
                    },

                    close() {
                        this.mobileOpen = false;
                        this.apply();
                    }
                },

                header: {
                    syncHeight() {
                        const header = document.getElementById('app-header');
                        if (!header) return;

                        document.documentElement.style
                            .setProperty('--app-header-height', header.offsetHeight + 'px');
                    }
                },

                bindEvents() {
                    window.addEventListener('resize', () => {
                        UI.sidebar.apply();
                        UI.header.syncHeight();
                    });

                    document.addEventListener('keydown', e => {
                        if (e.key === 'Escape') UI.sidebar.close();
                    });

                    document.addEventListener('click', e => {
                        const toggle = e.target.closest('[data-sidebar-toggle]');
                        if (toggle) UI.sidebar.toggleMobile();

                        const link = e.target.closest('#sidebar a');
                        if (link && window.innerWidth < 1280) {
                            UI.sidebar.close();
                        }

                        const backdrop = e.target.closest('.mobile-backdrop');
                        if (backdrop) UI.sidebar.close();
                    });
                },

                init() {
                    UI.header.syncHeight();
                    UI.sidebar.apply();
                    UI.bindEvents();

                }
            };

            document.addEventListener('DOMContentLoaded', UI.init);
        })();
    </script>

    @stack('scripts')

</body>

</html>
