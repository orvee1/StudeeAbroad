<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - {{ config('app.name', 'Studee Abroad') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <a href="{{ route('home') }}" class="flex items-center gap-2 justify-center mb-6">
                <div class="h-10 w-10 rounded-xl bg-slate-900"></div>
                <div class="text-center">
                    <div class="text-sm font-semibold">{{ config('app.name', 'Studee Abroad') }}</div>
                    <div class="text-xs text-slate-500">Admin Panel Login</div>
                </div>
            </a>

            <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    <div class="text-xl font-semibold">Sign in as Admin</div>
                    <div class="text-sm text-slate-500">Use your admin credentials to continue.</div>
                </div>

                <form method="POST" action="{{ route('admin.login.store') }}" class="p-6 space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password" required
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                    </div>

                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remember" value="1" class="rounded border-slate-300">
                        Remember me
                    </label>

                    <button class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Login
                    </button>

                    <div class="text-xs text-slate-500 text-center">
                        Student? <a class="text-slate-900 hover:underline" href="{{ route('login') }}">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
