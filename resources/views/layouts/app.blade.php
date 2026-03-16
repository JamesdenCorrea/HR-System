<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' . config('app.name') : config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
<header style="background:white;border-bottom:3px solid;border-image:linear-gradient(135deg,#1e1b4b,#4f46e5,#7c3aed) 1;box-shadow:0 1px 8px rgba(79,70,229,0.1);">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        {{ $header }}
    </div>
</header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
