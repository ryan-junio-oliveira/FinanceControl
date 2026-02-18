<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FinanceControl')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white border-r border-gray-200 fixed h-screen hidden lg:block">
            <div class="h-full flex flex-col">
                {{-- Logo --}}
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-wallet text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Finance<span class="text-blue-600">Control</span></h1>
                        </div>
                    </a>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 px-4 py-6 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('expenses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition group {{ request()->routeIs('expenses.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-arrow-down w-5 text-center"></i>
                        <span>Despesas</span>
                    </a>
                    
                    <a href="{{ route('recipes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition group {{ request()->routeIs('recipes.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-arrow-up w-5 text-center"></i>
                        <span>Receitas</span>
                    </a>
                    
                    <a href="{{ route('monthly-controls.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition group {{ request()->routeIs('monthly-controls.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-calendar-alt w-5 text-center"></i>
                        <span>Controles Mensais</span>
                    </a>
                </nav>

                {{-- User Section --}}
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->username }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar (mobile header) --}}
            <header class="bg-white border-b border-gray-200 sticky top-0 z-10 lg:hidden">
                <div class="flex items-center justify-between px-4 py-4">
                    <h1 class="text-xl font-bold text-gray-900">Finance<span class="text-blue-600">Control</span></h1>
                    <button class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>