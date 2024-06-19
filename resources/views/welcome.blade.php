<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center">
    <div class="text-center p-6 bg-white rounded-lg shadow-lg">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="w-24 h-24 mx-auto mb-4"/>
        <h1 class="text-3xl font-semibold mb-2">SMA Rekomendasi</h1>
        <p class="text-xl mb-2">SMP Negeri 1 Kota Kediri</p>
        <p class="text-lg text-gray-600 mb-4">Jl. Pendidikan No. 123, Kediri, Jawa Timur</p>
        @if (Route::has('login'))
            <div class="mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300 space-x-2">
                       <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Login</span>
                    </a>
                    {{-- @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="ml-4 bg-green-500 text-white py-2 px-4 rounded hover:bg-green-700 transition duration-300">Register</a>
                    @endif --}}
                @endauth
            </div>
        @endif
    </div>
</div>
<footer class="text-center py-4 bg-gray-200 mt-6 w-full">
    &copy; {{ date('Y') }} SMA Rekomendasi - SMP Negeri 1 Kota Kediri. All rights reserved.
</footer>
</body>
</html>
