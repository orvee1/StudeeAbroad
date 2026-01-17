<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', config('app.name') . ' Admin')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen flex">
        <aside class="w-72 hidden lg:flex flex-col bg-white border-r border-slate-200">
            <div class="px-6 py-5 border-b border-slate-200">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-xl bg-slate-900"></div>
                    <div>
                        <div class="text-sm font-semibold">{{ config('app.name', 'Studee Abroad') }}</div>
                        <div class="text-xs text-slate-500">Admin Panel</div>
                    </div>
                </a>
            </div>

            <nav class="p-4 space-y-1 text-sm">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                    <span>Dashboard</span>
                </a>

                <div class="pt-3 pb-1 text-xs font-semibold text-slate-500 px-3">LOCATION</div>
                <a href="{{ route('countries.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                    <span>Countries</span>
                </a>
                <a href="{{ route('states.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                    <span>States</span>
                </a>
                <a href="{{ route('cities.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                    <span>Cities</span>
                </a>

                <div class="pt-3 pb-1 text-xs font-semibold text-slate-500 px-3">UNIVERSITIES</div>
                <a href="{{ route('universities.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                    <span>Universities</span>
                </a>

                <div class="pt-3 pb-1 text-xs font-semibold text-slate-500 px-3">STUDENTS</div>
                <a href="{{ route('students.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                    <span>Registered Students</span>
                </a>

                <div class="pt-3 pb-1 text-xs font-semibold text-slate-500 px-3">ACCOUNT</div>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50">
                    <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                    <span>Profile</span>
                </a>
            </nav>

            <div class="mt-auto p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500">@yield('breadcrumb', 'Admin')</div>
                        <div class="text-lg font-semibold">@yield('page_title', 'Dashboard')</div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block text-right">
                            <div class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                            @csrf
                            <button
                                class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="max-w-7xl mx-auto px-4 lg:px-8 py-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
