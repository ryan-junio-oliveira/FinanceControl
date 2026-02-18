<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FinanceControl')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</body>
</html>