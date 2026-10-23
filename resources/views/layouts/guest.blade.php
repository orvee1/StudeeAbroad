<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/exfreelance-logo-cropped.jpeg') }}">
    <title>{{ request()->routeIs('login') ? 'Log in' : 'Create account' }} | {{ config('app.name', 'EXFREELANCE') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="brand-theme min-h-screen bg-[#fbf9f4] font-sans text-[#183b36] antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="border-b border-[#e8e5db] bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                    <x-brand-mark />
                    <span><strong class="block text-sm tracking-tight">{{ config('app.name', 'EXFREELANCE') }}</strong><span class="block text-xs text-[#819087]">Your study-abroad guide</span></span>
                </a>
                <nav class="flex items-center gap-3 text-sm font-semibold">
                    <a href="{{ route('search') }}" class="hidden rounded-lg px-3 py-2 text-[#52665f] hover:bg-[#f7f8f3] sm:inline-flex">Universities</a>
                    <a href="{{ route('public.programs.index') }}" class="hidden rounded-lg px-3 py-2 text-[#52665f] hover:bg-[#f7f8f3] sm:inline-flex">Programs</a>
                    <a href="{{ route('home') }}" class="rounded-xl border border-[#dfe5df] px-3 py-2 text-[#174f46] hover:bg-[#f7f8f3]">Home</a>
                </nav>
            </div>
        </header>

        <main class="flex flex-1 items-center justify-center px-4 py-10 sm:px-6">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl border border-[#e5e5dc] bg-white shadow-[0_25px_70px_-45px_rgba(24,59,54,.35)] md:grid-cols-[.9fr_1.1fr]">
                <aside class="relative hidden overflow-hidden bg-[#174f46] p-9 text-white md:flex md:flex-col md:justify-between lg:p-12">
                    <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full border-[2rem] border-white/10"></div>
                    <div class="relative"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#f0b08b]">Study with a plan</p><h1 class="mt-4 text-3xl font-semibold leading-tight lg:text-4xl">Find a place where your next chapter can begin.</h1></div>
                    <p class="relative mt-12 max-w-sm text-sm leading-6 text-[#d4e2d7]">Explore destinations, compare university details and ask for guidance when you need it.</p>
                </aside>
                <section class="p-6 sm:p-9 lg:p-12">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">{{ request()->routeIs('login') ? 'Welcome back' : 'Get started' }}</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-[#183b36]">{{ request()->routeIs('login') ? 'Log in to your account' : 'Create your student account' }}</h2>
                    <p class="mt-2 text-sm leading-6 text-[#71817a]">{{ request()->routeIs('login') ? 'Continue exploring your study options.' : 'Keep your guidance requests and student stories together.' }}</p>
                    <div class="mt-7">{{ $slot }}</div>
                    @if (request()->routeIs('login'))
                        <p class="mt-6 border-t border-[#eeeee8] pt-5 text-sm text-[#687871]">New to {{ config('app.name', 'EXFREELANCE') }}? <a href="{{ route('register') }}" class="font-bold text-[#174f46] hover:text-[#b96748]">Create an account</a></p>
                    @endif
                </section>
            </div>
        </main>

        <footer class="border-t border-[#e8e5db] bg-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 text-xs text-[#71817a] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p>
                <nav class="flex gap-5" aria-label="Footer navigation"><a href="{{ route('home') }}" class="hover:text-[#174f46]">Home</a><a href="{{ route('search') }}" class="hover:text-[#174f46]">Universities</a><a href="{{ route('public.programs.index') }}" class="hover:text-[#174f46]">Programs</a></nav>
            </div>
        </footer>
    </div>
</body>
</html>
