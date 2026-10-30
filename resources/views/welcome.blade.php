<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="relative min-h-screen flex flex-col justify-center items-center selection:bg-red-500 selection:text-white">
            <div class="max-w-7xl mx-auto p-6 lg:p-8 text-center">
                <h1 class="text-4xl font-bold mb-4">Selamat Datang di Praktikum Pemrograman Web 2</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">Proyek Blog - Laravel Authentication & Middleware</p>
                
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/home') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-800 text-white dark:bg-white dark:text-gray-800 rounded-md hover:opacity-80">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-white rounded-md hover:opacity-80">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>