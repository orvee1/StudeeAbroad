<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <meta name="description" content="Contact our team for help with your study abroad plans.">
    <title>Contact us | {{ config('app.name', 'EXFREELANCE') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body id="top" class="brand-theme bg-[#fffaf5] font-sans text-[#133f39] antialiased">
    <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-[#ebe4d9] bg-[#fffaf5]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" />
            </a>
            <nav class="hidden items-center gap-3 text-sm font-semibold xl:flex" aria-label="Main navigation">
                <a href="{{ route('home') }}#destinations" class="home-nav-link">Destinations</a>
                <a href="{{ route('home') }}#universities" class="home-nav-link">Universities</a>
                <a href="{{ route('public.programs.index') }}" class="home-nav-link">Programs</a>
                <a href="{{ route('home') }}#stories" class="home-nav-link">Student stories</a>
                <a href="{{ route('contact') }}" aria-current="page" class="home-nav-link">Contact us</a>
            </nav>
            <div class="hidden items-center gap-3 xl:flex">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-2.5 text-sm font-semibold text-white shadow-md">{{ auth()->user()->isAdmin() ? 'Admin dashboard' : 'My dashboard' }}</a>
                @else
                    <a href="{{ route('login') }}" class="home-nav-link text-sm font-semibold">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-2.5 text-sm font-semibold text-white shadow-md">Create account</a>
                @endauth
            </div>
            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-navigation" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#d9e0d8] text-[#0b6158] xl:hidden" aria-label="Toggle navigation">
                <svg x-show="!open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <div id="mobile-navigation" x-show="open" x-cloak x-transition class="border-t border-[#ebe4d9] bg-[#fffaf5] px-4 py-4 xl:hidden">
            <nav class="mx-auto flex max-w-7xl flex-col gap-1 text-sm font-medium" aria-label="Mobile navigation">
                <a @click="open = false" href="{{ route('home') }}#destinations" class="home-nav-link">Destinations</a>
                <a @click="open = false" href="{{ route('home') }}#universities" class="home-nav-link">Universities</a>
                <a @click="open = false" href="{{ route('public.programs.index') }}" class="home-nav-link">Programs</a>
                <a @click="open = false" href="{{ route('home') }}#stories" class="home-nav-link">Student stories</a>
                <a @click="open = false" href="{{ route('contact') }}" aria-current="page" class="home-nav-link">Contact us</a>
                <div class="mt-3 flex gap-3 border-t border-[#ebe4d9] pt-3">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="w-full rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-3 text-center font-semibold text-white">{{ auth()->user()->isAdmin() ? 'Admin dashboard' : 'My dashboard' }}</a>
                    @else
                        <a href="{{ route('login') }}" class="home-nav-link flex-1 justify-center font-semibold">Log in</a>
                        <a href="{{ route('register') }}" class="flex-1 rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-3 text-center font-semibold text-white">Create account</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="border-b border-[#ebe4d9] bg-[radial-gradient(ellipse_at_10%_15%,rgba(211,241,226,.8),transparent_38%),radial-gradient(ellipse_at_92%_8%,rgba(255,222,202,.65),transparent_35%)]">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
                <p class="text-xs font-bold uppercase tracking-[.18em] text-[#b96748]">We’re here to help</p>
                <h1 class="mt-3 text-4xl font-semibold tracking-tight text-[#133f39] sm:text-5xl">Contact us</h1>
                <p class="mt-4 max-w-2xl text-base leading-7 text-[#5f716a]">Have a question about studying abroad? Send us a message or connect with our team directly.</p>
            </div>
        </section>

        <section class="px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-5xl">
                <x-enquiry-form source="contact" />
            </div>
        </section>

        <section aria-labelledby="other-ways-heading" class="border-t border-[#ebe4d9] bg-white px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">Find us and follow along</p>
                    <h2 id="other-ways-heading" class="mt-2 text-2xl font-semibold tracking-tight text-[#133f39] sm:text-3xl">Other ways to reach us</h2>
                </div>
                <div class="mt-7 grid gap-4 md:grid-cols-3">
                    <a href="https://www.google.com/maps/place/Freelancing+Digital+Marketing+SEO+SMM+and+PPC+Expert+and+Consultant+and+Training/@23.8815642,90.4415625,17z/data=!3m1!4b1!4m6!3m5!1s0x3755c132fceafbfb:0xbc504d26428263d0!8m2!3d23.8815642!4d90.4415625!16s%2Fg%2F11j4xsl_99" target="_blank" rel="noopener noreferrer" class="group flex min-h-40 flex-col justify-between rounded-2xl border border-[#e7e7df] bg-[#fffaf5] p-5 transition hover:-translate-y-0.5 hover:border-[#b8cabb] hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0b6158]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e7f3ea] text-lg text-[#0b6158]" aria-hidden="true">⌖</span>
                        <span class="mt-5"><span class="block font-bold text-[#133f39]">Google Maps</span><span class="mt-1 block text-sm text-[#687871]">Open our location and directions <span aria-hidden="true">→</span></span></span>
                    </a>
                    <a href="https://www.facebook.com/exfreelancebd/" target="_blank" rel="noopener noreferrer" class="group flex min-h-40 flex-col justify-between rounded-2xl border border-[#cfe0f3] bg-[#f5f9ff] p-5 transition hover:-translate-y-0.5 hover:border-[#1877f2]/50 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#1877f2]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#1877f2] text-2xl font-bold text-white" aria-hidden="true">f</span>
                        <span class="mt-5"><span class="block font-bold text-[#133f39]">Facebook</span><span class="mt-1 block text-sm text-[#687871]">Follow EXFREELANCE BD <span aria-hidden="true">→</span></span></span>
                    </a>
                    <a href="https://wa.me/8801965999950" target="_blank" rel="noopener noreferrer" class="group flex min-h-40 flex-col justify-between rounded-2xl border border-[#ccebd8] bg-[#f3fbf5] p-5 transition hover:-translate-y-0.5 hover:border-[#20b763]/60 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#20b763]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#20b763] text-sm font-bold text-white" aria-hidden="true">WA</span>
                        <span class="mt-5"><span class="block font-bold text-[#133f39]">WhatsApp</span><span class="mt-1 block text-sm text-[#687871]">Chat with us · +880 1965-999950 <span aria-hidden="true">→</span></span></span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-[#ebe4d9] bg-[#fffaf5]">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 text-xs text-[#71817a] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p>
            <nav class="flex gap-5" aria-label="Footer navigation"><a href="{{ route('home') }}" class="hover:text-[#174f46]">Home</a><a href="{{ route('contact') }}" class="hover:text-[#174f46]">Contact us</a></nav>
        </div>
    </footer>
</body>
</html>
