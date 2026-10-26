<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">

        <title>{{ config('app.name', 'EXFREELANCE') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="brand-theme font-sans antialiased">
        <div class="flex min-h-screen flex-col bg-[#fbf9f4]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
            <footer class="border-t border-[#e8e5db] bg-white">
                <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-6 text-sm text-[#71817a] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p>
                    <nav class="flex gap-5" aria-label="Footer navigation"><a class="hover:text-[#174f46]" href="{{ route('home') }}">Home</a><a class="hover:text-[#174f46]" href="{{ route('search') }}">Universities</a><a class="hover:text-[#174f46]" href="{{ route('public.programs.index') }}">Programs</a></nav>
                </div>
            </footer>
        </div>
    </body>
</html>
