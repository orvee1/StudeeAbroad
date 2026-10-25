<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><link rel="icon" type="image/jpeg" href="{{ asset('images/exfreelance-logo-cropped.jpeg') }}"><link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/exfreelance-logo-cropped.jpeg') }}">
    <title>{{ $country->meta_title ?: 'Study in ' . $country->name . ' | ' . config('app.name') }}</title>
    <meta name="description" content="{{ $country->meta_description ?: Str::limit(strip_tags($country->description ?: 'Explore universities and study programs in ' . $country->name . '.'), 155) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="brand-theme bg-[#fbf9f4] font-sans text-[#183b36] antialiased">
    <header class="border-b border-[#e8e5db] bg-white"><div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3"><x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" /><span><strong class="block text-sm">{{ config('app.name', 'EXFREELANCE') }}</strong><span class="text-xs text-[#819087]">Your study-abroad guide</span></span></a>
        <nav class="flex items-center gap-3 text-sm"><a href="{{ route('search', ['country_id' => $country->id]) }}" class="hidden font-semibold text-[#52665f] sm:inline">Find universities</a><a href="{{ route('public.programs.index', ['country_id' => $country->id]) }}" class="hidden font-semibold text-[#52665f] sm:inline">Find programs</a>@auth<a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-[#174f46] px-4 py-2.5 font-semibold text-white">Dashboard</a>@else<a href="{{ route('login') }}" class="font-semibold text-[#52665f]">Log in</a>@endauth</nav>
    </div></header>
    <main>
        <section class="bg-[#174f46] text-white"><div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
            <nav class="text-sm text-[#c5d8ce]" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2">/</span><span>Destinations</span></nav>
            <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end"><div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#f0b08b]">Study abroad destination</p><h1 class="mt-3 text-4xl font-semibold tracking-tight sm:text-5xl">Study in {{ $country->name }}</h1><p class="mt-4 max-w-2xl text-base leading-7 text-[#d4e2d7]">{{ $country->description ?: 'Explore universities, programs and student opportunities in ' . $country->name . '.' }}</p></div><a href="{{ route('search', ['country_id' => $country->id]) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#f0b08b] px-5 py-3.5 text-sm font-bold text-[#183b36]">Browse universities <span aria-hidden="true">→</span></a></div>
            <div class="mt-10 grid grid-cols-3 gap-3 border-t border-white/15 pt-6"><div><p class="text-2xl font-bold">{{ number_format($stats['universities']) }}</p><p class="mt-1 text-xs text-[#c5d8ce] sm:text-sm">Universities</p></div><div><p class="text-2xl font-bold">{{ number_format($stats['programs']) }}</p><p class="mt-1 text-xs text-[#c5d8ce] sm:text-sm">Programs</p></div><div><p class="text-2xl font-bold">{{ $country->currency ?: '—' }}</p><p class="mt-1 text-xs text-[#c5d8ce] sm:text-sm">Local currency</p></div></div>
        </div></section>
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">Explore the directory</p><h2 class="mt-2 text-3xl font-semibold tracking-tight">Universities in {{ $country->name }}</h2></div><a href="{{ route('public.programs.index', ['country_id' => $country->id]) }}" class="text-sm font-bold text-[#174f46]">Browse programs →</a></div>
            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($universities as $university)
                    <a href="{{ route('public.universities.show', $university->slug) }}" class="group rounded-2xl border border-[#e5e5dc] bg-white p-5 transition hover:-translate-y-1 hover:shadow-lg"><div class="flex items-start gap-3"><span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#eef2e9] font-bold text-[#38665a]">@if($university->logo_path)<img src="{{ asset('storage/' . ltrim($university->logo_path, '/')) }}" alt="" class="h-full w-full object-contain p-1">@else{{ mb_substr($university->name, 0, 1) }}@endif</span><span class="min-w-0"><strong class="block text-[#183b36]">{{ $university->name }}</strong><span class="mt-1 block text-xs text-[#819087]">{{ collect([$university->city?->name, $university->state?->name])->filter()->implode(', ') }}</span></span></div><div class="mt-5 flex items-center justify-between border-t border-[#eeeee8] pt-4 text-xs text-[#687871]"><span>{{ $university->programs_count }} programs</span><span class="font-semibold text-[#174f46] group-hover:text-[#b96748]">View profile →</span></div></a>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-10 text-center text-sm text-[#71817a]">University listings for this destination are being updated.</div>
                @endforelse
            </div>
            <div class="mt-6">{{ $universities->links() }}</div>
        </section>
        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8"><x-enquiry-form :country="$country" source="destination" /></section>
    </main>
<x-site-footer />
</body>
</html>
