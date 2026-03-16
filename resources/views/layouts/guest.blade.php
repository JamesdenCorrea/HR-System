<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR Management System') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family:'Figtree',sans-serif;background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 40%,#4f46e5 75%,#7c3aed 100%);min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;">

    <div style="margin-bottom:24px;text-align:center;">
        <img src="{{ asset('logo.png') }}"
             alt="HR Management System"
             style="height:56px;margin:0 auto 12px;display:block;object-fit:contain;filter:brightness(1.1);">
        <span style="color:white;font-weight:700;font-size:18px;letter-spacing:0.3px;">
            HR Management System
        </span>
    </div>

    <div style="width:100%;max-width:420px;background:white;border-radius:16px;padding:36px;box-shadow:0 25px 50px rgba(0,0,0,0.35);">
        {{ $slot }}
    </div>

    <p style="color:rgba(255,255,255,0.4);font-size:11px;margin-top:24px;">
        © {{ date('Y') }} HR Management System. All rights reserved.
    </p>

</body>
</html>