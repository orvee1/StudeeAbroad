<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/exfreelance-logo-cropped.jpeg') }}">

    <title>@yield('page_title', config('app.name', 'EXFREELANCE') . ' Admin')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>

@php
    $adminUser = auth()->user();
    $adminInitial = mb_strtoupper(mb_substr($adminUser?->name ?? 'A', 0, 1));
@endphp

<body class="min-h-screen bg-[#f4f7f5] font-sans text-slate-900 antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="fixed inset-y-0 left-0 z-30 hidden w-[17rem] flex-col border-r border-slate-200/80 bg-white lg:flex">
            <div class="border-b border-slate-100 px-5 py-5">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-2xl focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">
                    <x-brand-mark size="h-11 w-11" class="shadow-md shadow-emerald-900/15 transition group-hover:-translate-y-0.5" />
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-extrabold tracking-tight text-slate-950">{{ config('app.name', 'EXFREELANCE') }}</span>
                        <span class="mt-0.5 block text-[11px] font-semibold uppercase tracking-[.16em] text-slate-400">Admin workspace</span>
                    </span>
                </a>
            </div>

            <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5" aria-label="Admin navigation">
                <div>
                    <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Overview</p>
                    <a href="{{ route('dashboard') }}" @class(['group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('dashboard'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('dashboard')]) @if(request()->routeIs('dashboard')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="4" rx="1.5"/><rect x="13.5" y="10.5" width="7" height="10" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/></svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div>
                    <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Catalog &amp; enquiries</p>
                    <a href="{{ route('universities.index') }}" @class(['group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('universities.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('universities.*')]) @if(request()->routeIs('universities.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('universities.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 20.5h17M5.5 20V8.5l6.5-4 6.5 4V20M9 20v-5.5h6V20M8.5 10h.01M12 10h.01M15.5 10h.01"/></svg>
                        <span>Universities</span>
                    </a>
                    <a href="{{ route('leads.index') }}" @class(['group mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('leads.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('leads.*')]) @if(request()->routeIs('leads.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('leads.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3.5" y="5" width="17" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 7 7.5 5.5L19.5 7"/></svg>
                        <span>Enquiries</span>
                    </a>
                </div>

                <div>
                    <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Destinations</p>
                    <a href="{{ route('countries.index') }}" @class(['group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('countries.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('countries.*')]) @if(request()->routeIs('countries.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('countries.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.8 9h16.4M3.8 15h16.4M12 3.5c2.1 2.3 3.2 5.2 3.2 8.5s-1.1 6.2-3.2 8.5C9.9 18.2 8.8 15.3 8.8 12s1.1-6.2 3.2-8.5Z"/></svg>
                        <span>Countries</span>
                    </a>
                    <a href="{{ route('states.index') }}" @class(['group mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('states.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('states.*')]) @if(request()->routeIs('states.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('states.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5h16M6.5 5.5V20m11-14.5V20M4 20h16M6.5 10h11M6.5 15h11"/></svg>
                        <span>States</span>
                    </a>
                    <a href="{{ route('cities.index') }}" @class(['group mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('cities.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('cities.*')]) @if(request()->routeIs('cities.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('cities.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10c0 5.2-7.5 10.5-7.5 10.5S4.5 15.2 4.5 10a7.5 7.5 0 1 1 15 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <span>Cities</span>
                    </a>
                </div>

                <div>
                    <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Students</p>
                    <a href="{{ route('students.index') }}" @class(['group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('students.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('students.*')]) @if(request()->routeIs('students.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('students.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="8" r="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 20v-1.5a5.5 5.5 0 0 1 11 0V20M16 5.5a3 3 0 0 1 0 5.8m1 3.2a4.5 4.5 0 0 1 3.5 4.4V20"/></svg>
                        <span>Registered students</span>
                    </a>
                    <a href="{{ route('success_stories.index') }}" @class(['group mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('success_stories.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('success_stories.*')]) @if(request()->routeIs('success_stories.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('success_stories.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3.5 2.6 5.3 5.9.9-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9-4.3-4.2 5.9-.9L12 3.5Z"/></svg>
                        <span>Success stories</span>
                    </a>
                </div>

                <div>
                    <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Account</p>
                    <a href="{{ route('admin.profile.edit') }}" @class(['group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-bold transition duration-150', 'bg-emerald-50 text-emerald-900 ring-1 ring-inset ring-emerald-100' => request()->routeIs('admin.profile.*'), 'text-slate-600 hover:bg-slate-50 hover:text-slate-950' => !request()->routeIs('admin.profile.*')]) @if(request()->routeIs('admin.profile.*')) aria-current="page" @endif>
                        <svg class="h-5 w-5 shrink-0 {{ request()->routeIs('admin.profile.*') ? 'text-emerald-700' : 'text-slate-400 group-hover:text-slate-600' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/></svg>
                        <span>Profile</span>
                    </a>
                </div>
            </nav>

            <div class="border-t border-slate-100 p-3">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 rounded-2xl p-2.5 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-emerald-100 text-sm font-extrabold text-emerald-900">
                        @if ($adminUser?->profile_photo_path)
                            <img src="{{ asset('storage/' . ltrim($adminUser->profile_photo_path, '/')) }}" alt="{{ $adminUser->name }} profile photo" class="h-full w-full object-cover">
                        @else
                            {{ $adminInitial }}
                        @endif
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-bold text-slate-800">{{ $adminUser?->name ?? 'Admin' }}</span>
                        <span class="mt-0.5 block text-xs text-slate-500">Administrator</span>
                    </span>
                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L10.94 10 7.23 6.29a.75.75 0 1 1 1.06-1.06l4.24 4.24a.75.75 0 0 1 0 1.06l-4.24 4.24a.75.75 0 0 1-1.08 0Z" clip-rule="evenodd"/></svg>
                </a>
            </div>
        </aside>

        <div class="min-w-0 flex-1 lg:pl-[17rem]">
            <header x-data="{ navOpen: false, accountOpen: false }" @keydown.escape.window="navOpen = false; accountOpen = false" class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
                <div class="mx-auto flex max-w-[1600px] items-center justify-between gap-3 px-4 py-3.5 sm:px-6 xl:px-9">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="lg:hidden"><x-brand-mark size="h-9 w-9" /></span>
                        <button type="button" @click="navOpen = !navOpen" :aria-expanded="navOpen.toString()" aria-controls="admin-mobile-nav" aria-label="Toggle admin navigation" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 lg:hidden">
                            <svg x-show="!navOpen" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                            <svg x-cloak x-show="navOpen" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
                        </button>
                        <div class="min-w-0">
                            <div class="hidden truncate text-[11px] font-semibold text-slate-400 sm:block">@yield('breadcrumb', 'Admin')</div>
                            <h1 class="truncate text-base font-extrabold tracking-tight text-slate-950 sm:mt-0.5 sm:text-xl">@yield('page_title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="relative shrink-0" @click.outside="accountOpen = false">
                        <button type="button" @click="accountOpen = !accountOpen" :aria-expanded="accountOpen.toString()" aria-haspopup="menu" aria-controls="admin-account-menu" class="group flex items-center gap-2 rounded-2xl border border-slate-200 bg-white p-1.5 pr-2.5 shadow-sm transition hover:border-emerald-300 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 sm:gap-3 sm:pr-3">
                            <span class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-emerald-800 to-teal-600 text-sm font-extrabold text-white shadow-sm">
                                @if ($adminUser?->profile_photo_path)
                                    <img src="{{ asset('storage/' . ltrim($adminUser->profile_photo_path, '/')) }}" alt="{{ $adminUser->name }} profile photo" class="h-full w-full object-cover">
                                @else
                                    {{ $adminInitial }}
                                @endif
                            </span>
                            <span class="hidden min-w-0 text-left sm:block">
                                <span class="block max-w-36 truncate text-xs font-extrabold text-slate-800">{{ $adminUser?->name ?? 'Admin' }}</span>
                                <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[.12em] text-emerald-700">Administrator</span>
                            </span>
                            <svg class="hidden h-4 w-4 text-slate-400 transition group-hover:text-slate-600 sm:block" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        </button>

                        <div id="admin-account-menu" x-cloak x-show="accountOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="translate-y-1 scale-95 opacity-0" x-transition:enter-end="translate-y-0 scale-100 opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="translate-y-0 scale-100 opacity-100" x-transition:leave-end="translate-y-1 scale-95 opacity-0" role="menu" class="absolute right-0 mt-2.5 w-64 origin-top-right overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10">
                            <div class="border-b border-slate-100 px-3 py-3">
                                <p class="truncate text-sm font-extrabold text-slate-900">{{ $adminUser?->name ?? 'Admin' }}</p>
                                <p class="mt-0.5 truncate text-xs text-slate-500">{{ $adminUser?->email ?? '' }}</p>
                            </div>
                            <a href="{{ route('admin.profile.edit') }}" role="menuitem" class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/></svg>
                                <span>Account profile</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" role="menuitem" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-bold text-rose-700 transition hover:bg-rose-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 5H5.5A1.5 1.5 0 0 0 4 6.5v11A1.5 1.5 0 0 0 5.5 19H10M14 16l4-4-4-4m4 4H9"/></svg>
                                    <span>Log out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <nav id="admin-mobile-nav" x-cloak x-show="navOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="-translate-y-1 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-1 opacity-0" class="max-h-[calc(100vh-5rem)] space-y-4 overflow-y-auto border-t border-slate-100 bg-white px-4 py-4 sm:px-6 lg:hidden" aria-label="Admin navigation">
                    <div>
                        <p class="px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Overview</p>
                        <a href="{{ route('dashboard') }}" @class(['block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('dashboard'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('dashboard')])>Dashboard</a>
                    </div>
                    <div>
                        <p class="px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Catalog &amp; enquiries</p>
                        <a href="{{ route('universities.index') }}" @class(['block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('universities.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('universities.*')])>Universities</a>
                        <a href="{{ route('leads.index') }}" @class(['mt-1 block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('leads.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('leads.*')])>Enquiries</a>
                    </div>
                    <div>
                        <p class="px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Destinations</p>
                        <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
                            <a href="{{ route('countries.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('countries.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('countries.*')])>Countries</a>
                            <a href="{{ route('states.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('states.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('states.*')])>States</a>
                            <a href="{{ route('cities.index') }}" @class(['rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('cities.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('cities.*')])>Cities</a>
                        </div>
                    </div>
                    <div>
                        <p class="px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Students</p>
                        <a href="{{ route('students.index') }}" @class(['block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('students.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('students.*')])>Registered students</a>
                        <a href="{{ route('success_stories.index') }}" @class(['mt-1 block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('success_stories.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('success_stories.*')])>Success stories</a>
                    </div>
                    <div>
                        <p class="px-3 pb-1.5 text-[10px] font-extrabold uppercase tracking-[.18em] text-slate-400">Account</p>
                        <a href="{{ route('admin.profile.edit') }}" @class(['block rounded-xl px-3 py-2.5 text-sm font-bold transition', 'bg-emerald-50 text-emerald-900' => request()->routeIs('admin.profile.*'), 'text-slate-600 hover:bg-slate-50' => !request()->routeIs('admin.profile.*')])>Profile</a>
                    </div>
                </nav>
            </header>

            <main class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 sm:py-8 xl:px-9">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
