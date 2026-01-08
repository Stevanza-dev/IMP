<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/logonocap.png') }}" type="image/png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        <a href="/" class="mb-6 flex items-center gap-3 text-gray-700 hover:text-gray-900">
            <img src="{{ asset('images/logonocap.png') }}" alt="IMP Logo" class="w-10 h-10">
            <span class="font-semibold tracking-tight hidden sm:inline">IMP UNNES 2026</span>
        </a>

        <div class="w-full max-w-md bg-white border border-gray-100 shadow-sm rounded-2xl px-6 py-6 sm:px-8 sm:py-8">
            {{ $slot }}
        </div>
    </div>
</body>

</html>