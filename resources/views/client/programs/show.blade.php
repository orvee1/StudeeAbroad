<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $program->title }} at {{ $university->name }} | {{ config('app.name', 'Studee Abroad') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($program->notes ?: $program->entry_requirements ?: $program->title . ' at ' . $university->name), 155) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="brand-theme bg-[#fbf9f4] font-sans text-[#183b36] antialiased">
    <header class="border-b border-[#e8e5db] bg-white"><div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8"><a href="{{ route('home') }}" class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#174f46] text-xs font-bold text-white">SA</span><strong class="text-sm">{{ config('app.name', 'Studee Abroad') }}</strong></a><nav class="flex items-center gap-4 text-sm"><a href="{{ route('public.programs.index') }}" class="font-semibold text-[#52665f]">All programs</a>@auth<a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-[#174f46] px-4 py-2.5 font-semibold text-white">Dashboard</a>@else<a href="{{ route('login') }}" class="font-semibold text-[#52665f]">Log in</a>@endauth</nav></div></header>
    <main>
        <section class="bg-[#174f46] text-white"><div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8"><nav class="text-sm text-[#c5d8ce]" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span class="mx-2">/</span><a href="{{ route('public.universities.show', $university->slug) }}">{{ $university->name }}</a><span class="mx-2">/</span><span>{{ $program->title }}</span></nav><div class="mt-8 max-w-3xl"><p class="text-xs font-bold uppercase tracking-[.16em] text-[#f0b08b]">{{ $program->level }} program @if($program->field) · {{ $program->field }}@endif</p><h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-5xl">{{ $program->title }}</h1><p class="mt-4 text-lg text-[#d4e2d7]">{{ $university->name }} <span class="mx-2">·</span>{{ collect([$university->city?->name, $university->country?->name])->filter()->implode(', ') }}</p><a href="#enquiry" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-[#f0b08b] px-5 py-3.5 text-sm font-bold text-[#183b36]">Ask about this program <span aria-hidden="true">→</span></a></div></div></section>
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_20rem] lg:px-8 lg:py-14">
            <div class="space-y-8"><section><h2 class="text-2xl font-semibold">Program overview</h2><div class="mt-4 rounded-2xl border border-[#e6e5dc] bg-white p-6"><p class="text-sm leading-7 text-[#687871]">{{ $program->notes ?: 'Contact our team for further information about this program.' }}</p></div></section>
                @if($program->entry_requirements)<section><h2 class="text-2xl font-semibold">Entry requirements</h2><div class="mt-4 rounded-2xl border border-[#e6e5dc] bg-white p-6 text-sm leading-7 text-[#687871]">{!! nl2br(e($program->entry_requirements)) !!}</div></section>@endif
                @if($relatedPrograms->isNotEmpty())<section><h2 class="text-2xl font-semibold">Related programs</h2><div class="mt-4 space-y-3">@foreach($relatedPrograms as $related)<a href="{{ route('public.programs.show', ['university' => $university->slug, 'program' => $related->slug]) }}" class="block rounded-2xl border border-[#e6e5dc] bg-white p-5 font-bold hover:border-[#b8cabb]">{{ $related->title }}<span class="mt-1 block text-xs font-normal text-[#819087]">{{ $related->level }}@if($related->field) · {{ $related->field }}@endif</span></a>@endforeach</div></section>@endif
            </div>
            <aside class="rounded-2xl border border-[#e6e5dc] bg-white p-5 lg:sticky lg:top-24 lg:self-start">
                <h2 class="font-bold">Program details</h2>
                <dl class="mt-4 space-y-4 text-sm">
                    <div><dt class="text-xs text-[#819087]">Study level</dt><dd class="mt-1 font-semibold">{{ $program->level }}</dd></div>
                    @if($program->field)<div><dt class="text-xs text-[#819087]">Subject area</dt><dd class="mt-1 font-semibold">{{ $program->field }}</dd></div>@endif
                    <div><dt class="text-xs text-[#819087]">Duration</dt><dd class="mt-1 font-semibold">{{ $program->duration_months ? $program->duration_months . ' months' : 'Contact university' }}</dd></div>
                    <div><dt class="text-xs text-[#819087]">Language</dt><dd class="mt-1 font-semibold">{{ $program->language ?: 'Not listed' }}</dd></div>
                    @php
                        $annualMin = $program->tuition_per_year_min ?? ($program->tuition_per_semester_min !== null && $program->semesters_per_year ? $program->tuition_per_semester_min * $program->semesters_per_year : null);
                        $annualMax = $program->tuition_per_year_max ?? ($program->tuition_per_semester_max !== null && $program->semesters_per_year ? $program->tuition_per_semester_max * $program->semesters_per_year : null);
                    @endphp
                    <div><dt class="text-xs text-[#819087]">Annual tuition estimate</dt><dd class="mt-1 font-semibold">
                        @if ($annualMin !== null || $annualMax !== null)
                            {{ $university->country?->currency ? $university->country->currency . ' ' : '' }}{{ $annualMin !== null ? number_format($annualMin) : '—' }}–{{ $annualMax !== null ? number_format($annualMax) : '—' }}
                        @else
                            Contact university
                        @endif
                    </dd></div>
                    @if ($program->tuition_per_semester_min !== null || $program->tuition_per_semester_max !== null)
                        <div><dt class="text-xs text-[#819087]">Tuition per semester</dt><dd class="mt-1 font-semibold">{{ $university->country?->currency ? $university->country->currency . ' ' : '' }}{{ $program->tuition_per_semester_min !== null ? number_format($program->tuition_per_semester_min) : '—' }}–{{ $program->tuition_per_semester_max !== null ? number_format($program->tuition_per_semester_max) : '—' }}<span class="mt-1 block text-xs font-normal text-[#819087]">{{ $program->semesters_per_year }} {{ Str::plural('semester', $program->semesters_per_year) }} per year</span></dd></div>
                    @endif
                    <div><dt class="text-xs text-[#819087]">Available intakes</dt><dd class="mt-1 font-semibold">{{ $program->intake_months ? implode(', ', $program->intake_months) : 'Not listed' }}</dd></div>
                </dl>
                <a href="{{ route('public.universities.show', $university->slug) }}" class="mt-6 block text-sm font-bold text-[#174f46]">View university profile →</a>
            </aside>
        </div>
        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8"><x-enquiry-form :country="$university->country" :university="$university" :program="$program" source="program" /></section>
    </main>
<x-site-footer />
</body>
</html>
