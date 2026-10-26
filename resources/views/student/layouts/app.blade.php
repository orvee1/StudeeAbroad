<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <title>@yield('page_title', config('app.name', 'EXFREELANCE') . ' Student Portal')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
@php
    $student = auth()->user();
    $studentInitial = mb_strtoupper(mb_substr($student?->name ?? 'S', 0, 1));
@endphp
<body class="min-h-screen bg-[#f4f7f5] font-sans text-slate-900 antialiased">
<div class="min-h-screen lg:flex">
    <aside class="fixed inset-y-0 left-0 z-30 hidden w-[17rem] flex-col border-r border-slate-200/80 bg-white lg:flex">
        <div class="border-b border-slate-100 px-5 py-5">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 rounded-2xl">
                <x-brand-mark size="h-11 w-11" class="shadow-md shadow-emerald-900/15" />
                <span class="min-w-0"><span class="block truncate text-sm font-extrabold tracking-tight text-slate-950">{{ config('app.name', 'EXFREELANCE') }}</span><span class="mt-0.5 block text-[11px] font-semibold uppercase tracking-[.16em] text-slate-400">Student workspace</span></span>
            </a>
        </div>
        <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5" aria-label="Student navigation">
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Overview</p>
                <a href="{{ route('student.dashboard') }}" @class(['flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('student.dashboard'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('student.dashboard')])>Dashboard</a>
            </div>
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Explore</p>
                <a href="{{ route('search') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50">Universities</a>
                <a href="{{ route('public.programs.index') }}" class="mt-1 block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50">Programs</a>
            </div>
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">My activity</p>
                <a href="{{ route('student.enquiries.index') }}" @class(['block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('student.enquiries.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('student.enquiries.*')])>My enquiries</a>
                <a href="{{ route('student.success_stories.index') }}" @class(['mt-1 block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('student.success_stories.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('student.success_stories.*')])>My success stories</a>
            </div>
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Account</p>
                <a href="{{ route('profile.edit') }}" @class(['block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('profile.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('profile.*')])>Profile</a>
            </div>
        </nav>
        <div class="border-t border-slate-100 p-3">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-2xl p-2.5 transition hover:bg-slate-50">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-emerald-100 text-sm font-extrabold text-emerald-900">@if($student?->profile_photo_path)<img src="{{ asset('storage/' . ltrim($student->profile_photo_path, '/')) }}" alt="{{ $student->name }} profile photo" class="h-full w-full object-cover">@else{{ $studentInitial }}@endif</span>
                <span class="min-w-0 flex-1"><span class="block truncate text-sm font-bold text-slate-800">{{ $student?->name ?? 'Student' }}</span><span class="mt-0.5 block text-xs text-slate-500">Student</span></span>
            </a>
        </div>
    </aside>
    <div class="min-w-0 flex-1 lg:pl-[17rem]">
        <header x-data="{ navOpen: false, accountOpen: false }" @keydown.escape.window="navOpen = false; accountOpen = false" class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
            <div class="mx-auto flex max-w-[1600px] items-center justify-between gap-3 px-4 py-3.5 sm:px-6 xl:px-9">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="lg:hidden"><x-brand-mark size="h-9 w-9" /></span>
                    <button type="button" @click="navOpen = !navOpen" :aria-expanded="navOpen.toString()" aria-controls="student-mobile-nav" aria-label="Toggle student navigation" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm lg:hidden"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg></button>
                    <div class="min-w-0"><div class="hidden truncate text-[11px] font-semibold text-slate-400 sm:block">@yield('breadcrumb', 'Student / Workspace')</div><h1 class="truncate text-base font-extrabold tracking-tight text-slate-950 sm:mt-0.5 sm:text-xl">@yield('page_title', 'Student Dashboard')</h1></div>
                </div>
                <div class="relative shrink-0" @click.outside="accountOpen = false">
                    <button type="button" @click="accountOpen = !accountOpen" :aria-expanded="accountOpen.toString()" aria-haspopup="menu" aria-controls="student-account-menu" class="group flex items-center gap-2 rounded-2xl border border-slate-200 bg-white p-1.5 pr-2.5 shadow-sm hover:border-emerald-300 sm:gap-3 sm:pr-3">
                        <span class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-emerald-100 text-sm font-extrabold text-emerald-900">@if($student?->profile_photo_path)<img src="{{ asset('storage/' . ltrim($student->profile_photo_path, '/')) }}" alt="{{ $student->name }} profile photo" class="h-full w-full object-cover">@else{{ $studentInitial }}@endif</span>
                        <span class="hidden min-w-0 text-left sm:block"><span class="block max-w-36 truncate text-xs font-extrabold text-slate-800">{{ $student?->name ?? 'Student' }}</span><span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[.12em] text-emerald-700">Student</span></span>
                        <svg class="hidden h-4 w-4 text-slate-400 sm:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    </button>
                    <div id="student-account-menu" x-cloak x-show="accountOpen" x-transition role="menu" class="absolute right-0 mt-2.5 w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl">
                        <div class="border-b border-slate-100 px-3 py-3"><p class="truncate text-sm font-extrabold text-slate-900">{{ $student?->name ?? 'Student' }}</p><p class="mt-0.5 truncate text-xs text-slate-500">{{ $student?->email ?? '' }}</p></div>
                        <a href="{{ route('profile.edit') }}" role="menuitem" class="mt-1 block rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Account profile</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" role="menuitem" class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-bold text-rose-700 hover:bg-rose-50">Log out</button></form>
                    </div>
                </div>
            </div>
            <nav id="student-mobile-nav" x-cloak x-show="navOpen" class="space-y-1 overflow-y-auto border-t border-slate-100 bg-white px-4 py-4 lg:hidden" aria-label="Student navigation">
                <a href="{{ route('student.dashboard') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">Dashboard</a><a href="{{ route('search') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">Universities</a><a href="{{ route('public.programs.index') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">Programs</a><a href="{{ route('student.enquiries.index') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">My enquiries</a><a href="{{ route('student.success_stories.index') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">My success stories</a><a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">Profile</a>
            </nav>
        </header>
        <main class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 xl:px-9 xl:py-8">@yield('content')</main>
        <footer class="border-t border-slate-200 bg-white"><div class="mx-auto flex max-w-[1600px] flex-col gap-2 px-4 py-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 xl:px-9"><p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p><nav class="flex gap-5" aria-label="Footer navigation"><a class="hover:text-emerald-800" href="{{ route('home') }}">Home</a><a class="hover:text-emerald-800" href="{{ route('search') }}">Universities</a><a class="hover:text-emerald-800" href="{{ route('public.programs.index') }}">Programs</a></nav></div></footer>
    </div>
</body>
</html>