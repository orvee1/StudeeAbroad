<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <meta name="description" content="Plan your study abroad journey with university guidance, student visa and immigration support, accommodation assistance and air ticketing.">
    <title>{{ config('app.name', 'EXFREELANCE') }} — Find your place to study</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body id="top" class="brand-theme bg-[#fffaf5] font-sans text-[#133f39] antialiased">
    @php
        $stats = $stats ?? ['countries' => 0, 'universities' => 0, 'programs' => 0, 'support' => '1:1'];
        $topCountries = $topCountries ?? collect();
        $featuredUniversities = $featuredUniversities ?? collect();
        $successStories = $successStories ?? collect();
        $badgeStyle = fn ($badge) => match ($badge) {
            'Admitted' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
            'Offer Received' => 'bg-indigo-50 text-indigo-800 ring-indigo-200',
            'Visa Approved' => 'bg-amber-50 text-amber-800 ring-amber-200',
            default => 'bg-stone-100 text-stone-700 ring-stone-200',
        };
    @endphp

    <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-[#ebe4d9] bg-[#fffaf5]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8 xl:gap-1">
            <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" />
            </a>

            <nav class="hidden shrink-0 items-center gap-3 text-sm font-semibold xl:flex xl:gap-1" aria-label="Main navigation">
                <a href="#destinations" class="home-nav-link whitespace-nowrap">Destinations</a>
                <a href="#universities" class="home-nav-link whitespace-nowrap">Universities</a>
                <a href="#services" class="home-nav-link whitespace-nowrap">Our services</a>
                <a href="{{ route('public.programs.index') }}" class="home-nav-link whitespace-nowrap">Programs</a>
                <a href="#stories" class="home-nav-link whitespace-nowrap">Student stories</a>
                <a href="{{ route('contact') }}" class="home-nav-link whitespace-nowrap">Contact us</a>
            </nav>

            <div class="hidden shrink-0 items-center gap-3 xl:flex xl:gap-1">
                @auth
                    <a href="#enquiry" class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl bg-[#ef8b22] px-3.5 py-2.5 text-sm font-bold text-[#142b4a] shadow-sm transition hover:-translate-y-0.5 hover:bg-[#d96a18] hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ef8b22] focus-visible:ring-offset-2">
                        Talk with our team
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h6m-8 8 2.7-3H17a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v7a3 3 0 0 0 1 2.3V20Z"/></svg>
                    </a>
                    <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="whitespace-nowrap rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-[#0757a6]/20 transition duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0aa9cf] focus-visible:ring-offset-2">{{ auth()->user()->isAdmin() ? 'Admin dashboard' : 'My dashboard' }}</a>
                @else
                    <a href="#enquiry" class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl bg-[#ef8b22] px-3.5 py-2.5 text-sm font-bold text-[#142b4a] shadow-sm transition hover:-translate-y-0.5 hover:bg-[#d96a18] hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ef8b22] focus-visible:ring-offset-2">
                        Talk with our team
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h6m-8 8 2.7-3H17a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v7a3 3 0 0 0 1 2.3V20Z"/></svg>
                    </a>
                    <a href="{{ route('login') }}" class="home-nav-link whitespace-nowrap text-sm font-semibold">Log in</a>
                    <a href="{{ route('register') }}" class="whitespace-nowrap rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-[#0757a6]/20 transition duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0aa9cf] focus-visible:ring-offset-2">Create account</a>
                @endauth
            </div>

            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-navigation" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#d9e0d8] text-[#0b6158] xl:hidden" aria-label="Toggle navigation">
                <svg x-show="!open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <div id="mobile-navigation" x-show="open" x-cloak x-transition class="border-t border-[#ebe4d9] bg-[#fffaf5] px-4 py-4 xl:hidden">
            <nav class="mx-auto flex max-w-7xl flex-col gap-1 text-sm font-medium" aria-label="Mobile navigation">
                    <a @click="open = false" href="#destinations" class="home-nav-link">Destinations</a>
                    <a @click="open = false" href="#universities" class="home-nav-link">Universities</a>
                    <a @click="open = false" href="#services" class="home-nav-link">Our services</a>
                    <a @click="open = false" href="{{ route('public.programs.index') }}" class="home-nav-link">Programs</a>
                    <a @click="open = false" href="#stories" class="home-nav-link">Student stories</a>
                    <a @click="open = false" href="{{ route('contact') }}" class="home-nav-link">Contact us</a>
                <div class="mt-3 border-t border-[#ebe4d9] pt-3">
                    <a @click="open = false" href="#enquiry" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#ef8b22] px-4 py-3 text-center font-bold text-[#142b4a] shadow-sm transition hover:bg-[#d96a18]">
                        Talk with our team
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h6m-8 8 2.7-3H17a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v7a3 3 0 0 0 1 2.3V20Z"/></svg>
                    </a>
                </div>
                <div class="mt-2 flex gap-3">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="w-full rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-3 text-center font-semibold text-white shadow-md shadow-[#0757a6]/20">{{ auth()->user()->isAdmin() ? 'Admin dashboard' : 'My dashboard' }}</a>
                    @else
                        <a href="{{ route('login') }}" class="home-nav-link flex-1 justify-center font-semibold">Log in</a>
                        <a href="{{ route('register') }}" class="flex-1 rounded-xl bg-gradient-to-r from-[#142b4a] via-[#0757a6] to-[#0aa9cf] px-4 py-3 text-center font-semibold text-white shadow-md shadow-[#0757a6]/20">Create account</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main>
        @php($heroSlides = $heroSlides ?? collect())
        <section aria-label="Study abroad highlights" class="bg-[#f4f8f5] pb-10 sm:pb-14">
            <div
                x-data="{
                    active: 0,
                    count: {{ $heroSlides->count() }},
                    timer: null,
                    paused: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
                    start() {
                        if (this.count < 2 || this.paused) return;
                        this.stop();
                        this.timer = window.setInterval(() => { this.active = (this.active + 1) % this.count; }, 5000);
                    },
                    stop() { if (this.timer) window.clearInterval(this.timer); this.timer = null; },
                    next() { if (this.count > 1) { this.active = (this.active + 1) % this.count; this.start(); } },
                    previous() { if (this.count > 1) { this.active = (this.active + this.count - 1) % this.count; this.start(); } },
                    goTo(index) { this.active = index; this.start(); },
                    togglePlayback() { this.paused = !this.paused; this.paused ? this.stop() : this.start(); }
                }"
                x-init="start()"
                @mouseenter="stop()"
                @mouseleave="start()"
                @focusin="stop()"
                @focusout="if (!$el.contains($event.relatedTarget)) start()"
                class="relative isolate h-[560px] overflow-hidden bg-[#102d48] sm:h-[620px] lg:h-[min(72vh,760px)]"
            >
                @forelse ($heroSlides as $index => $slide)
                    <div
                        x-cloak
                        x-show="active === {{ $index }}"
                        x-transition:enter="transition ease-out duration-1000"
                        x-transition:enter-start="opacity-0 scale-[1.025]"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-700"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-[1.025]"
                        class="absolute inset-0"
                        aria-hidden="true"
                    >
                        <img src="{{ asset('storage/' . ltrim($slide->image_path, '/')) }}" alt="" class="absolute inset-0 h-full w-full scale-110 object-cover object-center opacity-40 blur-2xl">
                        <img src="{{ asset('storage/' . ltrim($slide->image_path, '/')) }}" alt="" class="relative h-full w-full object-contain object-center">
                    </div>
                @empty
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_80%_20%,rgba(9,169,207,.55),transparent_40%),linear-gradient(120deg,#102d48,#0757a6_58%,#0b8eaa)]"></div>
                    <div class="absolute -right-24 -top-32 h-[34rem] w-[34rem] rounded-full border border-white/10"></div>
                    <div class="absolute -right-4 -top-12 h-[24rem] w-[24rem] rounded-full border border-white/10"></div>
                @endforelse

                <div class="absolute inset-0 bg-gradient-to-r from-[#091b2d]/85 via-[#102d48]/55 to-[#102d48]/10"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#091b2d]/60 via-transparent to-[#091b2d]/10"></div>

                <div class="relative mx-auto flex h-full max-w-7xl items-center px-5 pb-24 pt-14 sm:px-8 lg:px-10">
                    <div class="max-w-3xl text-white lg:ml-20">
                        <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-2 text-[11px] font-bold uppercase tracking-[.18em] text-white/90 shadow-sm backdrop-blur-sm sm:text-xs">
                            <span class="h-2 w-2 rounded-full bg-[#ff9a42] shadow-[0_0_0_4px_rgba(255,154,66,.18)]"></span>
                            STUDY ABROAD | STUDENT VISA | IMMIGRATION | ACCOMMODATION | AIR TICKETING
                        </p>
                        @forelse ($heroSlides as $index => $slide)
                            <div x-cloak x-show="active === {{ $index }}" x-transition.opacity.duration.500ms>
                                <h1 class="max-w-3xl text-4xl font-semibold leading-[1.08] tracking-[-.04em] drop-shadow-sm sm:text-5xl lg:text-7xl">{{ $slide->title }}</h1>
                                @if ($slide->subtitle)
                                    <p class="mt-5 max-w-2xl text-base leading-7 text-white/85 drop-shadow sm:text-lg sm:leading-8">{{ $slide->subtitle }}</p>
                                @endif
                                @if ($slide->button_text && $slide->button_url)
                                    <a href="{{ $slide->button_url }}" class="mt-7 inline-flex items-center gap-3 rounded-xl bg-[#ff922f] px-6 py-3.5 text-sm font-extrabold text-[#162c43] shadow-lg shadow-black/20 transition hover:-translate-y-0.5 hover:bg-[#ffa54e] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#102d48]">
                                        {{ $slide->button_text }}
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <h1 class="max-w-3xl text-4xl font-semibold leading-[1.08] tracking-[-.04em] drop-shadow-sm sm:text-5xl lg:text-7xl">A world of study. A place for you.</h1>
                            <p class="mt-5 max-w-2xl text-base leading-7 text-white/85 sm:text-lg sm:leading-8">Explore universities, compare the details that matter and find a destination that feels right for your future.</p>
                        @endforelse
                    </div>
                </div>

                @if ($heroSlides->count() > 1)
                    <button type="button" @click="togglePlayback()" :aria-label="paused ? 'Play slideshow' : 'Pause slideshow'" class="absolute right-4 top-5 z-20 flex h-10 w-10 items-center justify-center rounded-full border border-white/35 bg-black/20 text-white backdrop-blur transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:right-8 sm:top-7">
                        <svg x-cloak x-show="!paused" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5a1 1 0 0 1 1 1v12a1 1 0 1 1-2 0V6a1 1 0 0 1 1-1Zm8 0a1 1 0 0 1 1 1v12a1 1 0 1 1-2 0V6a1 1 0 0 1 1-1Z"/></svg>
                        <svg x-cloak x-show="paused" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8.5 5.8a1 1 0 0 1 1.52-.85l9 5.7a1.6 1.6 0 0 1 0 2.7l-9 5.7a1 1 0 0 1-1.52-.85V5.8Z"/></svg>
                    </button>
                    <div class="absolute bottom-6 left-5 z-10 flex items-center gap-2 sm:left-8 lg:left-[max(2rem,calc((100vw-80rem)/2+2.5rem))]">
                        <button type="button" @click="previous()" aria-label="Previous slide" class="hidden h-10 w-10 items-center justify-center rounded-full border border-white/35 bg-black/20 text-white backdrop-blur transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:flex">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <div class="flex items-center gap-1.5" role="group" aria-label="Choose a slide">
                            @foreach ($heroSlides as $index => $slide)
                                <button type="button" @click="goTo({{ $index }})" :aria-current="active === {{ $index }} ? 'true' : null" aria-label="Show slide {{ $index + 1 }}" class="h-2.5 rounded-full bg-white/55 transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white" :class="active === {{ $index }} ? 'w-8 !bg-white' : 'w-2.5 hover:bg-white/80'"></button>
                            @endforeach
                        </div>
                        <button type="button" @click="next()" aria-label="Next slide" class="hidden h-10 w-10 items-center justify-center rounded-full border border-white/35 bg-black/20 text-white backdrop-blur transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white sm:flex">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>
                @endif

                <a href="https://wa.me/8801965999950" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp at +880 1965-999950" title="Chat with us on WhatsApp" class="absolute left-4 top-4 z-20 inline-flex h-16 w-16 items-center justify-center rounded-full border-2 border-white/80 bg-[#25D366]/90 text-white shadow-[0_0_0_5px_rgba(37,211,102,.26),0_16px_36px_-8px_rgba(0,0,0,.65)] ring-2 ring-white/35 backdrop-blur-xl transition duration-200 hover:scale-105 hover:bg-[#20ba5a] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#102d48] sm:left-6 sm:top-6 lg:left-[max(1rem,calc((100vw-80rem)/2+1rem))] lg:top-1/2 lg:-translate-y-1/2">
                    <svg class="h-8 w-8 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.06 0C5.47 0 .1 5.36.1 11.96c0 2.1.55 4.15 1.6 5.96L0 24l6.23-1.63a11.96 11.96 0 0 0 5.83 1.49h.01c6.6 0 11.96-5.37 11.96-11.96 0-3.2-1.25-6.2-3.51-8.42ZM12.07 21.8h-.01a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.7.97.99-3.6-.24-.37a9.85 9.85 0 0 1-1.52-5.25c0-5.46 4.44-9.9 9.9-9.9a9.82 9.82 0 0 1 7 2.9 9.82 9.82 0 0 1 2.9 7c0 5.46-4.45 9.9-9.92 9.9Zm5.43-7.42c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.88-.78-1.48-1.75-1.65-2.05-.18-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.38-.03-.53-.08-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.1 3.2 5.08 4.48.7.3 1.25.49 1.68.62.7.22 1.34.19 1.84.12.56-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.18-1.42-.08-.13-.28-.2-.58-.35Z"/></svg>
                </a>
            </div>

            <div class="relative z-10 mx-auto -mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
                <form action="{{ route('search') }}" method="GET" class="rounded-3xl border border-[#e5e9e4] bg-white p-5 shadow-[0_24px_70px_-35px_rgba(19,45,57,.38)] sm:p-7">
                    <div class="mb-5 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                        <div><p class="text-xs font-bold uppercase tracking-[.17em] text-[#dc6d2b]">Take the next step</p><h2 class="mt-1 text-xl font-bold tracking-tight text-[#15334b] sm:text-2xl">Find a university that fits</h2></div>
                        <p class="text-sm text-[#708087]">Choose a destination or search by course.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-12 lg:items-end">
                        <div class="sm:col-span-2 lg:col-span-3"><label for="home_q" class="text-xs font-semibold text-[#687871]">University or keyword</label><input id="home_q" name="q" type="search" placeholder="e.g. business, Toronto, university" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm placeholder:text-[#9aa69f] focus:border-[#4e8273] focus:ring-[#4e8273]"></div>
                        <div class="lg:col-span-2"><label for="country_id" class="text-xs font-semibold text-[#687871]">Study destination</label><select name="country_id" id="country_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm text-[#344e46] focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any country</option>@foreach ($countries ?? [] as $country)<option value="{{ $country->id }}">{{ $country->name }}</option>@endforeach</select></div>
                        <div class="lg:col-span-2"><label for="state_id" class="text-xs font-semibold text-[#687871]">State / region</label><select name="state_id" id="state_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm text-[#344e46] focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any region</option></select></div>
                        <div class="lg:col-span-2"><label for="city_id" class="text-xs font-semibold text-[#687871]">City</label><select name="city_id" id="city_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm text-[#344e46] focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any city</option></select></div>
                        <div class="grid grid-cols-2 gap-2 sm:col-span-2 lg:col-span-2"><div><label for="tuition_min" class="text-xs font-semibold text-[#687871]">Tuition from</label><input id="tuition_min" name="tuition_min" type="number" min="0" placeholder="Min" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div><div><label for="tuition_max" class="text-xs font-semibold text-[#687871]">Tuition to</label><input id="tuition_max" name="tuition_max" type="number" min="0" placeholder="Max" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div></div>
                        <button type="submit" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-[#0757a6] px-5 text-sm font-bold text-white shadow-lg shadow-[#0757a6]/15 transition hover:bg-[#064785] focus:outline-none focus:ring-2 focus:ring-[#0aa9cf] focus:ring-offset-2 sm:col-span-2 lg:col-span-12">Find universities <span aria-hidden="true">→</span></button>
                    </div>
                </form>
            </div>
        </section>

        <section class="border-y border-[#ebe4d9] bg-white" aria-label="Study directory overview">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-5 px-4 py-6 sm:px-6 md:grid-cols-4 lg:px-8">
                <div class="border-l-2 border-[#ed8765] pl-4"><p class="text-2xl font-bold tracking-tight text-[#133f39]">{{ number_format((int) ($stats['countries'] ?? 0)) }}</p><p class="mt-1 text-xs font-medium text-[#71817a] sm:text-sm">Study destinations</p></div>
                <div class="border-l-2 border-[#abd9bc] pl-4"><p class="text-2xl font-bold tracking-tight text-[#133f39]">{{ number_format((int) ($stats['universities'] ?? 0)) }}</p><p class="mt-1 text-xs font-medium text-[#71817a] sm:text-sm">Universities to explore</p></div>
                <div class="border-l-2 border-[#b6a6e6] pl-4"><p class="text-2xl font-bold tracking-tight text-[#133f39]">{{ number_format((int) ($stats['programs'] ?? 0)) }}</p><p class="mt-1 text-xs font-medium text-[#71817a] sm:text-sm">Programs in our directory</p></div>
                <div class="border-l-2 border-[#f1c85c] pl-4"><p class="text-2xl font-bold tracking-tight text-[#133f39]">{{ $stats['support'] ?? '1:1' }}</p><p class="mt-1 text-xs font-medium text-[#71817a] sm:text-sm">Personal guidance</p></div>
            </div>
        </section>

        <section class="border-b border-[#e5ebe5] bg-white" aria-label="Our services at a glance">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-2 px-4 py-4 sm:grid-cols-3 sm:px-6 lg:grid-cols-5 lg:px-8">
                @foreach ([['01', 'Study abroad'], ['02', 'Student visa'], ['03', 'Immigration'], ['04', 'Accommodation'], ['05', 'Air ticketing']] as $service)
                    <a href="#services" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl border border-[#e6e5dc] bg-[#fffaf5] px-3 py-2 text-center text-sm font-semibold text-[#345c50] transition hover:border-[#abd9bc] hover:bg-[#f3f8f2] hover:text-[#0b6158]">
                        <span class="text-[11px] font-bold text-[#d96545]">{{ $service[0] }}</span>{{ $service[1] }}
                    </a>
                @endforeach
            </div>
        </section>

        <section id="how-it-works" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="grid gap-8 lg:grid-cols-[.75fr_1.25fr] lg:items-end">
                <div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">A simple place to begin</p><h2 class="mt-3 max-w-md text-3xl font-semibold leading-tight tracking-tight text-[#133f39] sm:text-4xl">Plan your next step.</h2></div>
                <p class="max-w-xl text-base leading-7 text-[#687871] lg:justify-self-end">A simple path from exploring destinations to getting personal guidance.</p>
            </div>
            <div class="mt-9 grid gap-4 md:grid-cols-3">
                @foreach ([['01', 'Choose a destination', 'Browse countries and listed universities.'], ['02', 'Compare your options', 'Filter by tuition, location, level and intake.'], ['03', 'Plan your next move', 'Create an account for your dashboard and guidance.']] as $step)
                    <article class="rounded-2xl border border-[#e6e5dc] bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg hover:shadow-[#0b6158]/10"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e4f5ec] text-sm font-bold text-[#2b776b]">{{ $step[0] }}</span><h3 class="mt-5 text-lg font-bold text-[#133f39]">{{ $step[1] }}</h3><p class="mt-2 text-sm leading-6 text-[#71817a]">{{ $step[2] }}</p></article>
                @endforeach
            </div>
        </section>

        <section id="destinations" class="border-y border-[#e5ebe5] bg-[#f3f8f2]">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">Go where you can grow</p><h2 class="mt-3 text-3xl font-semibold tracking-tight text-[#133f39] sm:text-4xl">Explore destinations</h2><p class="mt-3 max-w-xl text-sm leading-6 text-[#60736d]">Start with a country. Find universities, cities and programs that match your plans.</p></div><a href="{{ route('search') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#198b54] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#126b40] focus:outline-none focus:ring-2 focus:ring-[#198b54] focus:ring-offset-2">Browse all universities <span aria-hidden="true">→</span></a></div>
                <div class="mt-9 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @forelse($topCountries as $country)
                        <a href="{{ route('search', ['country_id' => $country->id]) }}" class="group rounded-2xl border border-[#e2e8df] bg-white p-5 transition hover:-translate-y-1 hover:border-[#abd9bc] hover:shadow-lg hover:shadow-[#0b6158]/10">
                            <div class="flex items-center gap-3"><span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#f8efe8] text-lg font-bold text-[#2b776b]">@if($country->flag_path)<img src="{{ asset('storage/' . ltrim($country->flag_path, '/')) }}" alt="" class="h-full w-full object-cover">@else{{ mb_substr($country->name, 0, 1) }}@endif</span><span class="min-w-0"><span class="block truncate font-bold text-[#133f39]">{{ $country->name }}</span><span class="mt-1 block text-xs text-[#819087]">{{ number_format($country->universities_count ?? 0) }} universities</span></span><span class="ml-auto text-[#9eaea4] transition group-hover:translate-x-1 group-hover:text-[#d96545]" aria-hidden="true">→</span></div>
                        </a>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-8 text-center text-sm text-[#71817a]">Destinations will appear here as they are added to the directory.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="universities" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">A good place to start</p><h2 class="mt-3 text-3xl font-semibold tracking-tight text-[#133f39] sm:text-4xl">Featured universities</h2><p class="mt-3 max-w-xl text-sm leading-6 text-[#60736d]">A selection from our active university directory.</p></div><a href="{{ route('search') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#ef8b22] px-4 py-2.5 text-sm font-bold text-[#142b4a] shadow-sm transition hover:bg-[#d96a18] focus:outline-none focus:ring-2 focus:ring-[#ef8b22] focus:ring-offset-2">See all universities <span aria-hidden="true">→</span></a></div>
            <div class="mt-9 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($featuredUniversities as $university)
                    <article class="group overflow-hidden rounded-2xl border border-[#e6e8df] bg-white transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#0b6158]/10">
                        <div class="relative flex h-36 items-end overflow-hidden bg-gradient-to-br from-[#d9f0df] via-[#f8edcf] to-[#ffd1b9] p-4">
                            @if($university->cover_path)<img src="{{ asset('storage/' . ltrim($university->cover_path, '/')) }}" alt="" class="absolute inset-0 h-full w-full object-cover">@else<div class="absolute -right-5 -top-10 h-40 w-40 rounded-full border-[1.2rem] border-white/40"></div><div class="absolute -right-2 -top-7 h-28 w-28 rounded-full bg-[#0b6158]/15"></div>@endif
                            <div class="relative flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-white/80 bg-white text-lg font-bold text-[#0b6158] shadow-sm">@if($university->logo_path)<img src="{{ asset('storage/' . ltrim($university->logo_path, '/')) }}" alt="{{ $university->name }} logo" class="h-full w-full object-contain p-1">@else{{ mb_substr($university->name, 0, 1) }}@endif</div>
                            @if($university->is_featured)<span class="relative ml-auto rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#2b776b]">Featured</span>@endif
                        </div>
                        <div class="p-5"><h3 class="line-clamp-2 min-h-[3.25rem] text-base font-bold leading-6 text-[#133f39]">{{ $university->name }}</h3><p class="mt-2 truncate text-xs text-[#819087]">{{ collect([$university->city?->name, $university->state?->name, $university->country?->name])->filter()->unique()->implode(', ') ?: 'Location details coming soon' }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">@if($university->world_ranking)<span class="rounded-full bg-[#f2f0e8] px-2.5 py-1 text-[11px] font-semibold text-[#52665f]">Rank #{{ number_format($university->world_ranking) }}</span>@endif @if($university->scholarship_available)<span class="rounded-full bg-[#fff0e8] px-2.5 py-1 text-[11px] font-semibold text-[#a65e41]">Scholarships</span>@endif</div>
                            <div class="mt-4 border-t border-[#eeeee8] pt-4">
                                <p class="text-[11px] font-semibold uppercase tracking-wide text-[#91a097]">Annual tuition</p>
                                <p class="mt-1 text-sm font-bold text-[#345c50]">
                                    @if ($university->tuition_min !== null || $university->tuition_max !== null)
                                        {{ $university->cost_currency ? $university->cost_currency . ' ' : '' }}{{ $university->tuition_min !== null ? number_format($university->tuition_min) : '—' }}–{{ $university->tuition_max !== null ? number_format($university->tuition_max) : '—' }}
                                    @else
                                        Contact university
                                    @endif
                                </p>
                            </div>
                        <a href="{{ route('public.universities.show', $university->slug) }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-[#0b6158] transition group-hover:text-[#d96545]">Explore university <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-8 text-center text-sm text-[#71817a]">Featured universities will appear here when available.</div>
                @endforelse
            </div>
        </section>

        <section id="stories" class="border-y border-[#e5ebe5] bg-[#f3f8f2]">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
                <div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">From students, for students</p><h2 class="mt-3 text-3xl font-semibold tracking-tight text-[#133f39] sm:text-4xl">Every journey has a story.</h2><p class="mt-3 text-sm leading-6 text-[#60736d]">A little perspective from students who have taken their next step.</p></div>
                <div class="mt-9 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    @forelse($successStories as $story)
                        @php($storyPhoto = $story->photo_path ?: ($story->user?->role === 'student' ? $story->user?->profile_photo_path : null))
                        <article class="flex flex-col rounded-2xl border border-[#e2e4d9] bg-white p-5 shadow-sm">
                            <div class="flex items-center gap-3"><span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#e7f3ea] text-sm font-bold text-[#2b776b]">@if($storyPhoto)<img src="{{ asset('storage/' . ltrim($storyPhoto, '/')) }}" alt="Photo of {{ $story->name }}" class="h-full w-full object-cover">@else{{ mb_substr($story->name, 0, 1) }}@endif</span><div class="min-w-0"><h3 class="truncate text-sm font-bold text-[#133f39]">{{ $story->name }}</h3><p class="truncate text-xs text-[#819087]">{{ $story->from ?: 'Student' }}</p></div></div>
                            @if($story->badge)<span class="mt-4 self-start rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $badgeStyle($story->badge) }}">{{ $story->badge }}</span>@endif
                            @if($story->destination)<p class="mt-3 text-sm font-semibold text-[#345c50]">{{ $story->destination }}</p>@endif
                            <blockquote class="mt-3 flex-1 text-sm leading-6 text-[#687871]">“{{ $story->story }}”</blockquote>
                            @if($story->year || $story->score)<div class="mt-4 flex flex-wrap gap-2 border-t border-[#eeeee8] pt-3">@if($story->year)<span class="text-xs font-medium text-[#819087]">{{ $story->year }}</span>@endif @if($story->score)<span class="text-xs font-medium text-[#819087]">{{ $story->score }}</span>@endif</div>@endif
                            <a href="{{ route('public.success_stories.show', $story) }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-[#0b6158] transition hover:text-[#d96545]">Read student story @if($story->media->isNotEmpty())<span class="text-xs font-medium text-[#819087]">· {{ $story->media->count() }} images</span>@endif <span aria-hidden="true">→</span></a>
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-8 text-center text-sm text-[#71817a]">Student stories will be shared here as they become available.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="services" class="border-b border-[#e5ebe5] bg-[#fffaf5]" aria-labelledby="services-heading">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">Support for the journey ahead</p>
                    <h2 id="services-heading" class="mt-3 text-3xl font-semibold tracking-tight text-[#133f39] sm:text-4xl">From choosing a course to settling in abroad.</h2>
                    <p class="mt-4 text-base leading-7 text-[#687871]">Studying overseas involves more than choosing a university. We help you understand the key steps and connect the parts of your journey, from study planning and visa preparation to accommodation and flights.</p>
                </div>

                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    @foreach ([
                        ['01', 'Study abroad', 'Explore study destinations, courses and universities that suit your goals and budget.'],
                        ['02', 'Student visa', 'Get practical guidance on student visa requirements, documents and application steps.'],
                        ['03', 'Immigration guidance', 'Understand relevant immigration options and the next steps for your plans.'],
                        ['04', 'Accommodation', 'Get help exploring places to stay and planning your move near your campus.'],
                        ['05', 'Air ticketing', 'Plan your trip and get support with flight options for your destination.'],
                    ] as $service)
                        <article class="rounded-2xl border border-[#e6e5dc] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg hover:shadow-[#0b6158]/10 sm:p-6">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e4f5ec] text-sm font-bold text-[#2b776b]">{{ $service[0] }}</span>
                            <h3 class="mt-5 text-base font-bold text-[#133f39]">{{ $service[1] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-[#71817a]">{{ $service[2] }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8 flex flex-col items-center gap-3 text-center sm:flex-row sm:justify-center sm:gap-5">
                    <p class="text-sm text-[#60736d]">Tell us where you want to go, and we’ll help you map out your next steps.</p>
                    <a href="#enquiry" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#ef8b22] px-5 py-3 text-sm font-bold text-[#142b4a] shadow-sm transition hover:bg-[#d96a18] focus:outline-none focus:ring-2 focus:ring-[#ef8b22] focus:ring-offset-2">Talk with our team <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <x-enquiry-form source="landing" />
        </section>

        <section class="border-y border-[#dce8f1] bg-[#eef7ff]" aria-labelledby="connect-heading">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8 lg:py-14">
                <a href="https://www.facebook.com/exfreelancebd/" target="_blank" rel="noopener noreferrer" aria-label="Visit EXFREELANCE BD on Facebook, opens in a new tab" class="group block rounded-[1.75rem] border border-[#cfe0f3] bg-white p-5 shadow-[0_18px_48px_-30px_rgba(20,43,74,.38)] transition duration-200 hover:-translate-y-0.5 hover:border-[#1877f2]/50 hover:shadow-[0_24px_55px_-28px_rgba(24,119,242,.35)] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#1877f2]/25 focus-visible:ring-offset-4 focus-visible:ring-offset-[#eef7ff] sm:p-7 lg:p-8">
                    <span class="flex flex-col gap-5 md:flex-row md:items-center md:gap-6">
                        <span class="flex h-20 w-20 shrink-0 items-center justify-center rounded-[1.4rem] bg-[#1877f2] text-white shadow-lg shadow-[#1877f2]/25 transition duration-200 group-hover:scale-105 group-hover:bg-[#0757a6] sm:h-24 sm:w-24" aria-hidden="true">
                            <svg class="h-12 w-12 sm:h-14 sm:w-14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073C24 5.446 18.627.073 12 .073S0 5.446 0 12.073c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.513c-1.491 0-1.956.926-1.956 1.876v2.252h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073Z"/></svg>
                        </span>

                        <span class="min-w-0 flex-1">
                            <span class="inline-flex items-center gap-2 rounded-full bg-[#eaf3ff] px-3 py-1 text-[11px] font-extrabold uppercase tracking-[.14em] text-[#0757a6]">Facebook page</span>
                            <span id="connect-heading" class="mt-2 block text-xl font-extrabold tracking-tight text-[#142b4a] sm:text-2xl">Follow EXFREELANCE BD on Facebook</span>
                            <span class="mt-1 block text-sm leading-6 text-[#58718a]">Study-abroad updates, practical guidance and student success stories.</span>
                        </span>

                        <span class="inline-flex w-full shrink-0 items-center justify-center gap-3 rounded-xl bg-[#1877f2] px-5 py-3.5 text-sm font-extrabold text-white shadow-md shadow-[#1877f2]/20 transition group-hover:bg-[#0757a6] sm:w-fit">
                            <span>Visit Facebook Page</span>
                            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </span>
                    </span>
                </a>
            </div>
        </section>

        <section class="px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <div class="mx-auto flex max-w-7xl flex-col gap-7 overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0b6158] via-[#0b6158] to-[#083f3a] px-6 py-9 text-white shadow-xl shadow-[#0b6158]/15 sm:px-10 lg:flex-row lg:items-center lg:justify-between lg:px-14 lg:py-12">
                <div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#b9f0d2]">Your next chapter</p><h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Ready to see what’s out there?</h2><p class="mt-3 max-w-xl text-sm leading-6 text-[#dcf0e4]">Search universities and compare the details that help you make a confident choice.</p></div>
                <a href="{{ route('search') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#ff9e76] px-5 py-3.5 text-sm font-bold text-[#133f39] transition hover:bg-[#ffc1a4]">Explore universities <span aria-hidden="true">→</span></a>
            </div>
        </section>
    </main>

    <footer id="footer" class="brand-footer">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2 xl:grid-cols-[1.2fr_.8fr_.8fr_1.2fr] lg:px-8 lg:py-14">
            <div class="max-w-sm">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home"><x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" /></a>
                <p class="mt-4 text-sm leading-6 text-white/75">Explore study destinations and find universities that fit your plans.</p>
                <a href="https://wa.me/8801965999950" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp at +880 1965-999950" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-[#4ac782]/45 bg-[#20b763]/20 px-3.5 py-2.5 text-sm font-bold text-white transition hover:bg-[#20b763]/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#4ac782] focus-visible:ring-offset-2 focus-visible:ring-offset-[#102d48]"><span class="text-[#69db97]" aria-hidden="true">WhatsApp</span><span>+880 1965-999950</span></a>
            </div>
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffc15e]">Explore</h2>
                <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-white/80" aria-label="Footer navigation">
                    <a href="{{ route('search') }}" class="transition hover:text-white">Find universities</a>
                    <a href="{{ route('public.programs.index') }}" class="transition hover:text-white">Find programs</a>
                    <a href="#destinations" class="transition hover:text-white">Study destinations</a>
                    <a href="#universities" class="transition hover:text-white">Featured universities</a>
                </nav>
            </div>
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffc15e]">Your journey</h2>
                <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-white/80" aria-label="Journey links">
                    <a href="#how-it-works" class="transition hover:text-white">How it works</a>
                    <a href="#stories" class="transition hover:text-white">Student stories</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-white">Contact us</a>
                    <a href="#top" class="transition hover:text-white">Back to top ↑</a>
                </nav>
            </div>
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffc15e]">Visit us</h2>
                <a href="https://www.google.com/maps/place/Freelancing+Digital+Marketing+SEO+SMM+and+PPC+Expert+and+Consultant+and+Training/@23.8815642,90.4415625,17z/data=!3m1!4b1!4m6!3m5!1s0x3755c132fceafbfb:0xbc504d26428263d0!8m2!3d23.8815642!4d90.4415625!16s%2Fg%2F11j4xsl_99?entry=tts&amp;g_ep=EgoyMDI2MTEwNC4wIOC7DCoASAFQAw%3D%3D&amp;skid=5be6654c-1d38-4a40-a876-3b3a483c4423" target="_blank" rel="noopener noreferrer" aria-label="Open our location details in Google Maps" class="group mt-4 block rounded-2xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#ff9e76] focus-visible:ring-offset-2 focus-visible:ring-offset-[#102d48]">
                    <span class="relative block h-48 overflow-hidden rounded-2xl border border-white/15 bg-white/10">
                        <iframe title="Map showing our location" src="https://maps.google.com/maps?q=23.8815642%2C90.4415625&amp;z=17&amp;output=embed" class="pointer-events-none h-full w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" aria-hidden="true" tabindex="-1"></iframe>
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 flex items-center justify-between bg-gradient-to-t from-[#083f3a]/95 to-transparent px-4 pb-3 pt-10 text-sm font-bold text-white">
                            View location in Google Maps <span aria-hidden="true" class="transition group-hover:translate-x-1">→</span>
                        </span>
                    </span>
                    <span class="mt-3 block text-sm font-semibold leading-5 text-white">Freelancing Digital Marketing, SEO, SMM and PPC</span>
                    <span class="mt-1 block text-xs leading-5 text-white/70">Tap the map to see full details and directions.</span>
                </a>
            </div>
        </div>
        <div class="border-t border-white/15">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-white/65 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p>
                <p>Find your place to study.</p>
            </div>
        </div>
    </footer>

    <script>
        (() => {
            const country = document.getElementById('country_id');
            const state = document.getElementById('state_id');
            const city = document.getElementById('city_id');

            async function populate(select, endpoint, emptyLabel) {
                select.innerHTML = '';
                select.add(new Option(emptyLabel, ''));
                if (!endpoint) return;
                select.disabled = true;
                try {
                    const response = await fetch(endpoint, { headers: { Accept: 'application/json' } });
                    if (!response.ok) throw new Error('Could not load locations');
                    (await response.json()).forEach(item => select.add(new Option(item.name, item.id)));
                } catch (error) {
                    select.add(new Option('Could not load options', ''));
                } finally {
                    select.disabled = false;
                }
            }

            country?.addEventListener('change', async () => {
                await populate(state, country.value ? `{{ route('api.states') }}?country_id=${encodeURIComponent(country.value)}` : '', 'Any region');
                await populate(city, '', 'Any city');
            });
            state?.addEventListener('change', () => populate(city, state.value ? `{{ route('api.cities') }}?state_id=${encodeURIComponent(state.value)}` : '', 'Any city'));
        })();
    </script>
</body>
</html>
