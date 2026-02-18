<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FinanceControl')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="antialiased bg-gradient-to-br from-slate-50 to-blue-50 text-slate-900">
    <main class="flex items-center justify-center min-h-screen flex-col">
        @yield('content')
    </main>
</body>

</html>
