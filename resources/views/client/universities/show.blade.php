<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $university->meta_title ?: $university->name . ' | ' . config('app.name') }}</title>
    <meta name="description" content="{{ $university->meta_description ?: Str::limit(strip_tags($university->short_description ?: $university->description ?: 'Explore courses, tuition, admissions and student opportunities at ' . $university->name . '.'), 155) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="brand-theme bg-[#fbf9f4] font-sans text-[#183b36] antialiased">
    <header class="border-b border-[#e8e5db] bg-white"><div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8"><a href="{{ route('home') }}" class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#174f46] text-xs font-bold text-white">SA</span><span><strong class="block text-sm">{{ config('app.name', 'Studee Abroad') }}</strong><span class="text-xs text-[#819087]">Your study-abroad guide</span></span></a><nav class="flex items-center gap-3 text-sm"><a href="{{ route('search') }}" class="hidden font-semibold text-[#52665f] sm:inline">Universities</a><a href="{{ route('public.programs.index') }}" class="hidden font-semibold text-[#52665f] sm:inline">Programs</a>@auth<a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-[#174f46] px-4 py-2.5 font-semibold text-white">Dashboard</a>@else<a href="{{ route('login') }}" class="font-semibold text-[#52665f]">Log in</a>@endauth</nav></div></header>
    <main>
        <section class="relative isolate overflow-hidden bg-[#174f46] text-white"><div class="absolute inset-y-0 right-0 -z-10 w-1/2 bg-[radial-gradient(ellipse_at_80%_10%,rgba(240,176,139,.45),transparent_55%)]"></div><div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8"><nav class="text-sm text-[#c5d8ce]" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-white">Home</a><span class="mx-2">/</span><a href="{{ route('search') }}" class="hover:text-white">Universities</a><span class="mx-2">/</span><span>{{ $university->name }}</span></nav><div class="mt-8 flex flex-col gap-6 sm:flex-row sm:items-center"><div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-3xl bg-white text-3xl font-bold text-[#174f46] shadow-lg">@if($university->logo_path)<img src="{{ asset('storage/' . ltrim($university->logo_path, '/')) }}" alt="{{ $university->name }} logo" class="h-full w-full object-contain p-3">@else{{ mb_substr($university->name, 0, 1) }}@endif</div><div><p class="text-xs font-bold uppercase tracking-[.16em] text-[#f0b08b]">University profile</p><h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">{{ $university->name }}</h1><p class="mt-2 text-sm text-[#d4e2d7]">{{ collect([$university->city?->name, $university->state?->name, $university->country?->name])->filter()->unique()->implode(', ') }}</p></div><a href="#enquiry" class="sm:ml-auto inline-flex items-center justify-center rounded-xl bg-[#f0b08b] px-5 py-3 text-sm font-bold text-[#183b36]">Ask about this university</a></div><div class="mt-9 flex flex-wrap gap-2">@if($university->type)<span class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-semibold">{{ $university->type }}</span>@endif @if($university->world_ranking)<span class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-semibold">{{ $university->ranking_source ?: 'World ranking' }} #{{ number_format($university->world_ranking) }}{{ $university->ranking_year ? ' · ' . $university->ranking_year : '' }}</span>@endif @if($university->established_year)<span class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-semibold">Established {{ $university->established_year }}</span>@endif</div></div></section>
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_20rem] lg:px-8 lg:py-14">
            <div class="min-w-0 space-y-10">
                <section><div class="flex items-end justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">About the university</p><h2 class="mt-2 text-2xl font-semibold">Overview</h2></div>@if($university->website_url)<a href="{{ $university->website_url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-[#174f46]">Official website ↗</a>@endif</div><div class="mt-4 rounded-2xl border border-[#e6e5dc] bg-white p-6 text-sm leading-7 text-[#687871]">{!! nl2br(e($university->description ?: $university->short_description ?: 'University information will be updated soon.')) !!}</div></section>
                @if($university->media->isNotEmpty())
                    <section><h2 class="text-2xl font-semibold">Campus gallery</h2><div class="mt-4 grid gap-3 sm:grid-cols-2">@foreach($university->media as $media)<figure class="overflow-hidden rounded-2xl bg-[#e8eee6]"><img src="{{ asset('storage/' . ltrim($media->file_path, '/')) }}" alt="{{ $media->caption ?: $media->title ?: ($university->name . ' campus') }}" class="h-52 w-full object-cover">@if($media->caption)<figcaption class="p-3 text-xs text-[#687871]">{{ $media->caption }}</figcaption>@endif</figure>@endforeach</div></section>
                @endif
                <section id="programs"><div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">What you can study</p><h2 class="mt-2 text-2xl font-semibold">Programs at {{ $university->name }}</h2></div><a href="{{ route('public.programs.index', ['country_id' => $university->country_id]) }}" class="text-sm font-bold text-[#174f46]">Browse all programs →</a></div><div class="mt-5 space-y-3">@forelse($programs as $program)<a href="{{ route('public.programs.show', [$university->slug, $program->slug]) }}" class="group flex flex-col gap-4 rounded-2xl border border-[#e6e5dc] bg-white p-5 transition hover:border-[#b8cabb] hover:shadow-md sm:flex-row sm:items-center sm:justify-between"><div><h3 class="font-bold text-[#183b36]">{{ $program->title }}</h3><p class="mt-1 text-sm text-[#71817a]">{{ collect([$program->level, $program->field])->filter()->implode(' · ') }}</p><div class="mt-2 flex flex-wrap gap-2 text-xs text-[#819087]">@if($program->duration_months)<span>{{ floor($program->duration_months / 12) ? floor($program->duration_months / 12) . ' years' : $program->duration_months . ' months' }}</span>@endif @if($program->language)<span>{{ $program->language }}</span>@endif</div>
@php
    $annualMin = $program->tuition_per_year_min ?? ($program->tuition_per_semester_min !== null && $program->semesters_per_year ? $program->tuition_per_semester_min * $program->semesters_per_year : null);
    $annualMax = $program->tuition_per_year_max ?? ($program->tuition_per_semester_max !== null && $program->semesters_per_year ? $program->tuition_per_semester_max * $program->semesters_per_year : null);
@endphp
@if($annualMin !== null || $annualMax !== null)<p class="mt-2 text-sm font-semibold text-[#345c50]">{{ $university->country?->currency ? $university->country->currency . ' ' : '' }}{{ $annualMin !== null ? number_format($annualMin) : '—' }}–{{ $annualMax !== null ? number_format($annualMax) : '—' }} / year</p>@endif
@if($program->tuition_per_semester_min !== null || $program->tuition_per_semester_max !== null)<p class="mt-1 text-xs text-[#71817a]">{{ $university->country?->currency ? $university->country->currency . ' ' : '' }}{{ $program->tuition_per_semester_min !== null ? number_format($program->tuition_per_semester_min) : '—' }}–{{ $program->tuition_per_semester_max !== null ? number_format($program->tuition_per_semester_max) : '—' }} / semester · {{ $program->semesters_per_year }} {{ Str::plural('semester', $program->semesters_per_year) }} per year</p>@endif
</div><span class="shrink-0 text-sm font-bold text-[#174f46] group-hover:text-[#b96748]">View program →</span></a>@empty<div class="rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-8 text-sm text-[#71817a]">Program details for this university are being updated. Contact us for guidance.</div>@endforelse</div><div class="mt-5">{{ $programs->links() }}</div></section>
                @if($relatedUniversities->isNotEmpty())
                    <section><h2 class="text-2xl font-semibold">Explore nearby options</h2><div class="mt-4 grid gap-3 sm:grid-cols-3">@foreach($relatedUniversities as $related)<a href="{{ route('public.universities.show', $related->slug) }}" class="rounded-2xl border border-[#e6e5dc] bg-white p-4 text-sm font-semibold hover:border-[#b8cabb]">{{ $related->name }}<span class="mt-1 block text-xs font-normal text-[#819087]">{{ $related->city?->name }}</span></a>@endforeach</div></section>
                @endif
            </div>
            <aside class="space-y-4 lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-2xl border border-[#e6e5dc] bg-white p-5">
                    <h2 class="font-bold">At a glance</h2>
                    <dl class="mt-4 space-y-4 text-sm">
                        <div><dt class="text-xs text-[#819087]">Location</dt><dd class="mt-1 font-semibold">{{ collect([$university->city?->name, $university->state?->name, $university->country?->name])->filter()->implode(', ') }}</dd></div>
                        <div><dt class="text-xs text-[#819087]">Annual tuition</dt><dd class="mt-1 font-semibold">
                            @if ($university->tuition_min !== null || $university->tuition_max !== null)
                                {{ $university->cost_currency ? $university->cost_currency . ' ' : '' }}{{ $university->tuition_min !== null ? number_format($university->tuition_min) : '—' }}–{{ $university->tuition_max !== null ? number_format($university->tuition_max) : '—' }}
                            @else
                                Contact university
                            @endif
                        </dd></div>
                        <div><dt class="text-xs text-[#819087]">Living cost estimate</dt><dd class="mt-1 font-semibold">
                            @if ($university->living_cost_min !== null || $university->living_cost_max !== null)
                                {{ $university->cost_currency ? $university->cost_currency . ' ' : '' }}{{ $university->living_cost_min !== null ? number_format($university->living_cost_min) : '—' }}–{{ $university->living_cost_max !== null ? number_format($university->living_cost_max) : '—' }}
                            @else
                                Not listed
                            @endif
                        </dd></div>
                        <div><dt class="text-xs text-[#819087]">Scholarships</dt><dd class="mt-1 font-semibold">{{ is_null($university->scholarship_available) ? 'Not confirmed' : ($university->scholarship_available ? 'Available' : 'Not listed') }}</dd></div>
                        @if ($university->acceptance_rate)
                            <div><dt class="text-xs text-[#819087]">Acceptance rate</dt><dd class="mt-1 font-semibold">{{ $university->acceptance_rate }}%</dd></div>
                        @endif
                    </dl>
                </div>
                @if ($university->data_verified_at)
                    <p class="rounded-xl bg-[#edf4eb] p-4 text-xs leading-5 text-[#52665f]">Information last verified {{ $university->data_verified_at->format('M Y') }}.</p>
                @endif
            </aside>
        </div>
        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8"><x-enquiry-form :country="$university->country" :university="$university" source="university" /></section>
    </main>
<x-site-footer />
</body>
</html>
