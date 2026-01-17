<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', config('app.name', 'Studee Abroad'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-xl bg-slate-900"></div>
                <div>
                    <div class="text-sm font-semibold">{{ config('app.name', 'Studee Abroad') }}</div>
                    <div class="text-xs text-slate-500">Student Portal</div>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right">
                    <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-500">Student</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div
            class="max-w-7xl mx-auto px-4 lg:px-8 py-6 text-sm text-slate-500 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
            <div>© {{ date('Y') }} {{ config('app.name', 'Studee Abroad') }}. All rights reserved.</div>
            <div class="flex gap-3">
                <a class="hover:text-slate-700" href="#">Support</a>
                <a class="hover:text-slate-700" href="#">Privacy</a>
                <a class="hover:text-slate-700" href="#">Terms</a>
            </div>
        </div>
    </footer>
</body>

</html>
