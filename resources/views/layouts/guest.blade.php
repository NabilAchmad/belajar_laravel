<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased">
        <div class="min-h-screen w-full lg:grid lg:grid-cols-2">

            <div class="hidden lg:flex flex-col items-center justify-center p-12 bg-gradient-to-br from-purple-600 to-indigo-600 text-white">
                <div class="text-center">
                    <a href="/" class="inline-block mb-8">
                        {{-- PERUBAHAN 1: Logo buku untuk tampilan desktop --}}
                        <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </a>
                    <h1 class="text-4xl font-bold tracking-tight">Selamat Datang Kembali</h1>
                    <p class="mt-4 text-lg text-purple-200 max-w-sm mx-auto">
                        Masuk untuk melanjutkan petualangan membaca Anda di PerpusOnline.
                    </p>
                </div>
            </div>

            <div class="flex flex-col justify-center items-center p-6 sm:p-12 w-full bg-gray-100">
                <div class="lg:hidden mb-6">
                    <a href="/">
                        {{-- PERUBAHAN 2: Logo buku untuk tampilan mobile --}}
                        <svg class="w-20 h-20 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </a>
                </div>

                <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl rounded-2xl">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>