<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', config('app.name', 'Studee Abroad'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-[#fbf9f4] font-sans text-[#183b36] antialiased">
    <header x-data="{ open: false }" class="sticky top-0 z-30 border-b border-[#e8e5db] bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="{{ config('app.name', 'Studee Abroad') }} home">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#174f46] text-xs font-bold text-white">SA</span>
                <span><strong class="block text-sm tracking-tight">{{ config('app.name', 'Studee Abroad') }}</strong><span class="block text-xs text-[#819087]">Student portal</span></span>
            </a>
            <nav class="hidden items-center gap-5 text-sm font-semibold text-[#52665f] lg:flex" aria-label="Student navigation">
                <a href="{{ route('search') }}" class="transition hover:text-[#174f46]">Universities</a>
                <a href="{{ route('public.programs.index') }}" class="transition hover:text-[#174f46]">Programs</a>
                <a href="{{ route('student.enquiries.index') }}" class="transition hover:text-[#174f46]">My enquiries</a>
                <a href="{{ route('student.success_stories.index') }}" class="transition hover:text-[#174f46]">My stories</a>
            </nav>
            <div class="flex items-center gap-2">
                <span class="hidden h-9 w-9 overflow-hidden rounded-xl bg-[#dff1e5] text-center text-sm font-bold leading-9 text-[#174f46] sm:block">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . ltrim(auth()->user()->profile_photo_path, '/')) }}" alt="{{ auth()->user()->name }} profile photo" class="h-full w-full object-cover">
                    @else
                        {{ mb_strtoupper(mb_substr(auth()->user()->name ?: 'S', 0, 1)) }}
                    @endif
                </span>
                <span class="hidden text-right sm:block"><strong class="block text-sm">{{ auth()->user()->name }}</strong><span class="block text-xs text-[#819087]">Student</span></span>
                <a href="{{ route('profile.edit') }}" class="hidden rounded-xl border border-[#dfe5df] px-3 py-2 text-sm font-semibold text-[#174f46] hover:bg-[#f7f8f3] sm:inline-flex">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button class="rounded-xl bg-[#174f46] px-3 py-2 text-sm font-semibold text-white transition hover:bg-[#103e37]">Log out</button>
                </form>
                <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="student-mobile-nav" class="rounded-xl border border-[#dfe5df] px-3 py-2 text-sm font-semibold text-[#174f46] lg:hidden"><span x-text="open ? 'Close' : 'Menu'"></span></button>
            </div>
        </div>
        <nav id="student-mobile-nav" x-cloak x-show="open" class="space-y-1 border-t border-[#e8e5db] px-4 py-3 text-sm font-semibold lg:hidden" aria-label="Student navigation">
            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 hover:bg-[#f7f8f3]">Home</a>
            <a href="{{ route('search') }}" class="block rounded-lg px-3 py-2 hover:bg-[#f7f8f3]">Universities</a>
            <a href="{{ route('public.programs.index') }}" class="block rounded-lg px-3 py-2 hover:bg-[#f7f8f3]">Programs</a>
            <a href="{{ route('student.enquiries.index') }}" class="block rounded-lg px-3 py-2 hover:bg-[#f7f8f3]">My enquiries</a>
            <a href="{{ route('student.success_stories.index') }}" class="block rounded-lg px-3 py-2 hover:bg-[#f7f8f3]">My success stories</a>
            <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 hover:bg-[#f7f8f3]">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="px-3 pt-2">
                @csrf
                <button class="w-full rounded-xl bg-[#174f46] px-4 py-2.5 text-left font-semibold text-white">Log out</button>
            </form>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        @yield('content')
    </main>

    <footer class="mt-10 border-t border-[#e8e5db] bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-6 text-sm text-[#71817a] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} {{ config('app.name', 'Studee Abroad') }}. All rights reserved.</p>
            <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="Footer navigation"><a class="hover:text-[#174f46]" href="{{ route('home') }}">Home</a><a class="hover:text-[#174f46]" href="{{ route('search') }}">Universities</a><a class="hover:text-[#174f46]" href="{{ route('public.programs.index') }}">Programs</a></nav>
        </div>
    </footer>
</body>
</html>
