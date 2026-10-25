<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/exfreelance-logo-cropped.jpeg') }}">
    <meta name="description" content="Explore universities and study destinations around the world. Compare tuition, rankings and programs to plan your next step.">
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
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" />
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium text-[#47645f] md:flex" aria-label="Main navigation">
                <a href="#destinations" class="transition hover:text-[#0b6158]">Destinations</a>
                <a href="#universities" class="transition hover:text-[#0b6158]">Universities</a>
                <a href="{{ route('public.programs.index') }}" class="transition hover:text-[#0b6158]">Programs</a>
                <a href="#stories" class="transition hover:text-[#0b6158]">Student stories</a>
                <a href="#how-it-works" class="transition hover:text-[#0b6158]">How it works</a>
            </nav>

            <div class="hidden items-center gap-3 sm:flex">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-[#0b6158] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#083f3a]">{{ auth()->user()->isAdmin() ? 'Admin dashboard' : 'My dashboard' }}</a>
                @else
                    <a href="{{ route('login') }}" class="px-2 py-2 text-sm font-semibold text-[#47645f] transition hover:text-[#0b6158]">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#0b6158] px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-[#0b6158]/20 transition hover:bg-[#083f3a]">Create account</a>
                @endauth
            </div>

            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-navigation" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#d9e0d8] text-[#0b6158] sm:hidden" aria-label="Toggle navigation">
                <svg x-show="!open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <div id="mobile-navigation" x-show="open" x-cloak x-transition class="border-t border-[#ebe4d9] bg-[#fffaf5] px-4 py-4 sm:hidden">
            <nav class="mx-auto flex max-w-7xl flex-col gap-1 text-sm font-medium" aria-label="Mobile navigation">
                    <a @click="open = false" href="#destinations" class="rounded-lg px-3 py-2.5 hover:bg-white">Destinations</a>
                    <a @click="open = false" href="#universities" class="rounded-lg px-3 py-2.5 hover:bg-white">Universities</a>
                    <a @click="open = false" href="{{ route('public.programs.index') }}" class="rounded-lg px-3 py-2.5 hover:bg-white">Programs</a>
                    <a @click="open = false" href="#stories" class="rounded-lg px-3 py-2.5 hover:bg-white">Student stories</a>
                <a @click="open = false" href="#how-it-works" class="rounded-lg px-3 py-2.5 hover:bg-white">How it works</a>
                <div class="mt-2 flex gap-3 border-t border-[#ebe4d9] pt-3">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="w-full rounded-xl bg-[#0b6158] px-4 py-3 text-center font-semibold text-white">{{ auth()->user()->isAdmin() ? 'Admin dashboard' : 'My dashboard' }}</a>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 rounded-xl border border-[#cbd7ce] px-4 py-3 text-center font-semibold text-[#0b6158]">Log in</a>
                        <a href="{{ route('register') }}" class="flex-1 rounded-xl bg-[#0b6158] px-4 py-3 text-center font-semibold text-white">Create account</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="relative isolate overflow-hidden">
            <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_10%_15%,rgba(211,241,226,.95),transparent_38%),radial-gradient(ellipse_at_92%_8%,rgba(255,222,202,.8),transparent_30%)]"></div>
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-12 sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-20">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#cfe6d9] bg-white/85 px-3.5 py-2 text-xs font-semibold tracking-wide text-[#2b776b] shadow-sm shadow-[#0b6158]/5">
                        <span class="h-2 w-2 rounded-full bg-[#ed7958]"></span> Make your next move count
                    </div>
                    <h1 class="mt-6 max-w-xl text-[2.65rem] font-semibold leading-[1.08] tracking-[-.045em] text-[#133f39] sm:text-5xl lg:text-[3.65rem]">A world of study. <span class="text-[#d96545]">A place for you.</span></h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-[#5f716a] sm:text-lg">Explore universities, compare the details that matter and find a destination that feels right for your future.</p>

                    <form action="{{ route('search') }}" method="GET" class="mt-8 rounded-[1.6rem] border border-[#e9e5dd] bg-white p-4 shadow-[0_22px_60px_-35px_rgba(19,63,57,.35)] sm:p-5">
                        <div class="mb-4 flex items-center gap-2 text-sm font-bold text-[#133f39]"><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#e4f5ec] text-[#2b776b]" aria-hidden="true">⌕</span>Start exploring</div>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="sm:col-span-2"><label for="home_q" class="text-xs font-semibold text-[#687871]">University or keyword</label><input id="home_q" name="q" type="search" placeholder="e.g. business, Toronto, university name" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm placeholder:text-[#9aa69f] focus:border-[#4e8273] focus:ring-[#4e8273]"></div>
                            <div><label for="country_id" class="text-xs font-semibold text-[#687871]">Study destination</label><select name="country_id" id="country_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm text-[#344e46] focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any country</option>@foreach ($countries ?? [] as $country)<option value="{{ $country->id }}">{{ $country->name }}</option>@endforeach</select></div>
                            <div><label for="state_id" class="text-xs font-semibold text-[#687871]">State / region</label><select name="state_id" id="state_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm text-[#344e46] focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any region</option></select></div>
                            <div><label for="city_id" class="text-xs font-semibold text-[#687871]">City</label><select name="city_id" id="city_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm text-[#344e46] focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any city</option></select></div>
                            <div class="grid grid-cols-2 gap-2"><div><label for="tuition_min" class="text-xs font-semibold text-[#687871]">Tuition from</label><input id="tuition_min" name="tuition_min" type="number" min="0" placeholder="Min" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div><div><label for="tuition_max" class="text-xs font-semibold text-[#687871]">Tuition to</label><input id="tuition_max" name="tuition_max" type="number" min="0" placeholder="Max" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-[#fdfdfb] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div></div>
                        </div>
                        <button type="submit" class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-[#0b6158] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#0b6158]/15 transition hover:bg-[#083f3a] focus:outline-none focus:ring-2 focus:ring-[#2b8a7b] focus:ring-offset-2">Find universities <span aria-hidden="true">→</span></button>
                        <p class="mt-3 text-center text-xs text-[#829088]">Adjust your search any time with more filters.</p>
                    </form>
                </div>

                <div class="relative mx-auto w-full max-w-[31rem] lg:ml-auto">
                    <div class="absolute -right-5 -top-5 h-28 w-28 rounded-full bg-[#ffb08f]/45 blur-xl"></div>
                    <div class="absolute -bottom-8 -left-8 h-36 w-36 rounded-full bg-[#b4dec8]/60 blur-xl"></div>
                    <div class="relative overflow-hidden rounded-[2rem] border border-[#23806f] bg-gradient-to-br from-[#0b6158] via-[#0b6158] to-[#083f3a] p-6 text-white shadow-[0_30px_70px_-30px_rgba(11,97,88,.6)] sm:p-8">
                        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/10"></div><div class="absolute -right-10 -top-10 h-44 w-44 rounded-full border border-white/10"></div>
                        <div class="relative flex min-h-[22rem] flex-col justify-between sm:min-h-[25rem]">
                            <div class="flex items-start justify-between gap-4"><div><p class="text-xs font-semibold uppercase tracking-[.18em] text-[#c5ead9]">Your journey, your pace</p><h2 class="mt-3 max-w-xs text-3xl font-semibold leading-tight tracking-tight">The right choice starts with a good search.</h2></div><span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#ff9e76] text-2xl text-[#133f39] shadow-lg shadow-[#082f2b]/20" aria-hidden="true">✳</span></div>
                            <div class="relative mt-8">
                                <div class="absolute -left-3 top-4 h-24 w-24 rounded-full bg-[#bbd2bc]"></div><div class="absolute left-14 top-10 h-16 w-16 rounded-full bg-[#e9a27d]"></div><div class="absolute left-28 top-0 h-28 w-28 rounded-full border-[1.5rem] border-[#d9e7d8]"></div>
                                <div class="relative ml-auto max-w-[16rem] rounded-2xl border border-[#74b2a2] bg-[#2b7569] p-4 shadow-[0_18px_36px_-18px_rgba(4,31,26,.85)]">
                                    <div class="flex items-center justify-between"><span class="text-xs font-semibold tracking-[.01em] text-[#f7fff9]">Your search snapshot</span><span class="h-2 w-2 rounded-full bg-[#ff9e76]"></span></div>
                                    <div class="mt-4 grid grid-cols-2 gap-2"><div class="rounded-xl border border-white/10 bg-[#428b7e] p-3"><p class="text-[11px] text-[#d8eade]">Countries</p><p class="mt-1 text-xl font-bold text-white">{{ number_format((int) ($stats['countries'] ?? 0)) }}</p></div><div class="rounded-xl border border-white/10 bg-[#428b7e] p-3"><p class="text-[11px] text-[#d8eade]">Universities</p><p class="mt-1 text-xl font-bold text-white">{{ number_format((int) ($stats['universities'] ?? 0)) }}</p></div></div>
                                    <div class="mt-2 rounded-xl bg-[#f4eee2] px-3 py-2.5 text-xs font-semibold text-[#345c50]">Compare options at a glance <span class="float-right" aria-hidden="true">↗</span></div>
                                </div>
                            </div>
                            <p class="mt-6 text-xs text-[#c1d9cc]">A little clarity can take you a long way.</p>
                        </div>
                    </div>
                </div>
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

        <section id="how-it-works" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="grid gap-8 lg:grid-cols-[.75fr_1.25fr] lg:items-end">
                <div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">A simple place to begin</p><h2 class="mt-3 max-w-md text-3xl font-semibold leading-tight tracking-tight text-[#133f39] sm:text-4xl">Turn “where should I study?” into a clear next step.</h2></div>
                <p class="max-w-xl text-base leading-7 text-[#687871] lg:justify-self-end">Start broad, narrow down by what matters to you, then explore universities and the options they offer.</p>
            </div>
            <div class="mt-9 grid gap-4 md:grid-cols-3">
                @foreach ([['01', 'Choose a destination', 'Browse active countries and see universities listed for each place.'], ['02', 'Compare your options', 'Use tuition, location, study level and intake filters to refine your search.'], ['03', 'Plan your next move', 'Create an account to continue with your student dashboard and guidance.']] as $step)
                    <article class="rounded-2xl border border-[#e6e5dc] bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg hover:shadow-[#0b6158]/10"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e4f5ec] text-sm font-bold text-[#2b776b]">{{ $step[0] }}</span><h3 class="mt-5 text-lg font-bold text-[#133f39]">{{ $step[1] }}</h3><p class="mt-2 text-sm leading-6 text-[#71817a]">{{ $step[2] }}</p></article>
                @endforeach
            </div>
        </section>

        <section id="destinations" class="border-y border-[#e5ebe5] bg-[#f3f8f2]">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#d96545]">Go where you can grow</p><h2 class="mt-3 text-3xl font-semibold tracking-tight text-[#133f39] sm:text-4xl">Explore destinations</h2><p class="mt-3 max-w-xl text-sm leading-6 text-[#60736d]">Start with a country. Find universities, cities and programs that match your plans.</p></div><a href="{{ route('search') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#198b54] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#126b40] focus:outline-none focus:ring-2 focus:ring-[#198b54] focus:ring-offset-2">Browse all universities <span aria-hidden="true">→</span></a></div>
                <div class="mt-9 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @forelse($topCountries as $country)
                        <a href="{{ route('public.destinations.show', $country->slug) }}" class="group rounded-2xl border border-[#e2e8df] bg-white p-5 transition hover:-translate-y-1 hover:border-[#abd9bc] hover:shadow-lg hover:shadow-[#0b6158]/10">
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
                        @php($storyPhoto = $story->photo_path ?: $story->user?->profile_photo_path)
                        <article class="flex flex-col rounded-2xl border border-[#e2e4d9] bg-white p-5 shadow-sm">
                            <div class="flex items-center gap-3"><span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#e7f3ea] text-sm font-bold text-[#2b776b]">@if($storyPhoto)<img src="{{ asset('storage/' . ltrim($storyPhoto, '/')) }}" alt="Photo of {{ $story->name }}" class="h-full w-full object-cover">@else{{ mb_substr($story->name, 0, 1) }}@endif</span><div class="min-w-0"><h3 class="truncate text-sm font-bold text-[#133f39]">{{ $story->name }}</h3><p class="truncate text-xs text-[#819087]">{{ $story->from ?: 'Student' }}</p></div></div>
                            @if($story->badge)<span class="mt-4 self-start rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $badgeStyle($story->badge) }}">{{ $story->badge }}</span>@endif
                            @if($story->destination)<p class="mt-3 text-sm font-semibold text-[#345c50]">{{ $story->destination }}</p>@endif
                            <blockquote class="mt-3 flex-1 text-sm leading-6 text-[#687871]">“{{ $story->story }}”</blockquote>
                            @if($story->year || $story->score)<div class="mt-4 flex flex-wrap gap-2 border-t border-[#eeeee8] pt-3">@if($story->year)<span class="text-xs font-medium text-[#819087]">{{ $story->year }}</span>@endif @if($story->score)<span class="text-xs font-medium text-[#819087]">{{ $story->score }}</span>@endif</div>@endif
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-8 text-center text-sm text-[#71817a]">Student stories will be shared here as they become available.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <x-enquiry-form source="landing" />
        </section>

        <section class="px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <div class="mx-auto flex max-w-7xl flex-col gap-7 overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0b6158] via-[#0b6158] to-[#083f3a] px-6 py-9 text-white shadow-xl shadow-[#0b6158]/15 sm:px-10 lg:flex-row lg:items-center lg:justify-between lg:px-14 lg:py-12">
                <div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#b9f0d2]">Your next chapter</p><h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Ready to see what’s out there?</h2><p class="mt-3 max-w-xl text-sm leading-6 text-[#dcf0e4]">Search universities and compare the details that help you make a confident choice.</p></div>
                <a href="{{ route('search') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#ff9e76] px-5 py-3.5 text-sm font-bold text-[#133f39] transition hover:bg-[#ffc1a4]">Explore universities <span aria-hidden="true">→</span></a>
            </div>
        </section>
    </main>

    <footer id="footer" class="border-t border-[#1f675d] bg-[#0a453f] text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[1.2fr_.8fr_.8fr] lg:px-8 lg:py-14">
            <div class="max-w-sm">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home"><x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" /></a>
                <p class="mt-4 text-sm leading-6 text-[#c5d8ce]">Explore study destinations and find universities that fit your plans.</p>
            </div>
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffb08f]">Explore</h2>
                <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-[#e1ebe4]" aria-label="Footer navigation">
                    <a href="{{ route('search') }}" class="transition hover:text-white">Find universities</a>
                    <a href="{{ route('public.programs.index') }}" class="transition hover:text-white">Find programs</a>
                    <a href="#destinations" class="transition hover:text-white">Study destinations</a>
                    <a href="#universities" class="transition hover:text-white">Featured universities</a>
                </nav>
            </div>
            <div>
                <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffb08f]">Your journey</h2>
                <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-[#e1ebe4]" aria-label="Journey links">
                    <a href="#how-it-works" class="transition hover:text-white">How it works</a>
                    <a href="#stories" class="transition hover:text-white">Student stories</a>
                    <a href="#top" class="transition hover:text-white">Back to top ↑</a>
                </nav>
            </div>
        </div>
        <div class="border-t border-white/15">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-[#c5d8ce] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
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
