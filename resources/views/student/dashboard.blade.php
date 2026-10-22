@extends('student.layouts.app')

@section('page_title', 'Student Dashboard')

@section('content')
    <div class="space-y-8">
        <section class="overflow-hidden rounded-3xl bg-[#174f46] text-white shadow-sm">
            <div class="grid gap-8 px-6 py-8 sm:px-8 lg:grid-cols-[1fr_auto] lg:items-center lg:px-10 lg:py-10">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold text-[#f0b08b]">Your study-abroad journey</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">Welcome, {{ auth()->user()->name }}</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-[#d4e2d7] sm:text-base">Explore real university and program listings, then send an enquiry when you would like guidance.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('search') }}" class="rounded-xl bg-[#f0b08b] px-4 py-3 text-sm font-bold text-[#183b36] transition hover:bg-[#f5c4a6]">Find universities</a>
                        <a href="{{ route('public.programs.index') }}" class="rounded-xl border border-white/30 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Explore programs</a>
                    </div>
                </div>
                <div class="grid min-w-56 grid-cols-2 gap-3 lg:w-64">
                    <div class="rounded-2xl bg-white/10 p-4"><p class="text-xs text-[#d4e2d7]">Countries</p><p class="mt-1 text-2xl font-semibold">{{ number_format($quickStats['countries'] ?? 0) }}</p></div>
                    <div class="rounded-2xl bg-white/10 p-4"><p class="text-xs text-[#d4e2d7]">Universities</p><p class="mt-1 text-2xl font-semibold">{{ number_format($quickStats['universities'] ?? 0) }}</p></div>
                    <a href="{{ route('student.enquiries.index') }}" class="col-span-2 rounded-2xl bg-white/10 p-4 transition hover:bg-white/15"><p class="text-xs text-[#d4e2d7]">My enquiries</p><p class="mt-1 flex items-center justify-between text-2xl font-semibold"><span>{{ number_format($quickStats['enquiries'] ?? 0) }}</span><span class="text-sm font-semibold">View requests →</span></p></a>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.3fr_.7fr]">
            <div class="rounded-2xl border border-[#e5e5dc] bg-white p-5 sm:p-6">
                <div class="flex items-end justify-between gap-4">
                    <div><p class="text-xs font-bold uppercase tracking-[.14em] text-[#b96748]">Stay up to date</p><h2 class="mt-2 text-xl font-semibold text-[#183b36]">Recent enquiries</h2></div>
                    <a href="{{ route('student.enquiries.index') }}" class="text-sm font-bold text-[#174f46] hover:text-[#b96748]">View all</a>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse($latestEnquiries as $enquiry)
                        <article class="rounded-xl border border-[#eeeee8] p-4">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div><p class="font-semibold text-[#183b36]">{{ $enquiry->desiredUniversity?->name ?: 'Study guidance request' }}</p><p class="mt-1 text-sm text-[#687871]">{{ collect([$enquiry->desiredCountry?->name, $enquiry->desired_level, $enquiry->preferred_intake])->filter()->implode(' · ') ?: 'General enquiry' }}</p></div>
                                <span class="self-start rounded-full bg-[#edf4eb] px-3 py-1 text-xs font-semibold capitalize text-[#38665a]">{{ $enquiry->status }}</span>
                            </div>
                            <p class="mt-2 text-xs text-[#819087]">Submitted {{ $enquiry->created_at?->format('d M Y') }}</p>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-[#d5ddd2] px-5 py-8 text-center">
                            <h3 class="font-semibold text-[#183b36]">No enquiries yet</h3>
                            <p class="mt-2 text-sm text-[#71817a]">When you request guidance with this email, your request will appear here.</p>
                            <a href="{{ route('public.programs.index') }}" class="mt-4 inline-flex rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-semibold text-white">Browse programs</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="rounded-2xl border border-[#e5e5dc] bg-white p-5 sm:p-6">
                <p class="text-xs font-bold uppercase tracking-[.14em] text-[#b96748]">Your account</p>
                <h2 class="mt-2 text-xl font-semibold text-[#183b36]">Keep your details current</h2>
                <p class="mt-2 text-sm leading-6 text-[#687871]">Your contact details help our team respond to guidance requests.</p>
                <div class="mt-5 grid gap-3">
                    <a href="{{ route('profile.edit') }}" class="rounded-xl border border-[#dfe5df] px-4 py-3 text-sm font-semibold text-[#174f46] hover:bg-[#f7f8f3]">Update profile</a>
                    <a href="{{ route('student.success_stories.index') }}" class="rounded-xl border border-[#dfe5df] px-4 py-3 text-sm font-semibold text-[#174f46] hover:bg-[#f7f8f3]">My success stories</a>
                    <a href="{{ route('home') }}" class="rounded-xl border border-[#dfe5df] px-4 py-3 text-sm font-semibold text-[#174f46] hover:bg-[#f7f8f3]">Visit homepage</a>
                </div>
            </aside>
        </section>

        <section id="featured-universities">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div><p class="text-xs font-bold uppercase tracking-[.14em] text-[#b96748]">A place to start</p><h2 class="mt-2 text-2xl font-semibold text-[#183b36]">Featured universities</h2><p class="mt-2 text-sm text-[#687871]">Explore details and available programs from the directory.</p></div>
                <a href="{{ route('search') }}" class="text-sm font-bold text-[#174f46] hover:text-[#b96748]">Browse all universities →</a>
            </div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @forelse($featuredUniversities as $university)
                    <a href="{{ route('public.universities.show', $university->slug) }}" class="group rounded-2xl border border-[#e5e5dc] bg-white p-5 transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center gap-3">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#eef2e9] text-lg font-bold text-[#38665a]">@if($university->logo_path)<img src="{{ asset('storage/' . ltrim($university->logo_path, '/')) }}" alt="" class="h-full w-full object-contain p-1">@else{{ mb_substr($university->name, 0, 1) }}@endif</span>
                            <span class="min-w-0"><strong class="block truncate text-sm text-[#183b36]">{{ $university->name }}</strong><span class="mt-1 block truncate text-xs text-[#819087]">{{ collect([$university->city?->name, $university->country?->name])->filter()->implode(', ') }}</span></span>
                        </div>
                        <p class="mt-4 text-sm text-[#687871]">{{ number_format($university->programs_count) }} {{ Str::plural('active program', $university->programs_count) }}</p>
                        <span class="mt-4 inline-flex text-sm font-bold text-[#174f46] group-hover:text-[#b96748]">View university →</span>
                    </a>
                @empty
                    <div class="rounded-2xl border border-dashed border-[#d5ddd2] bg-white p-8 text-center text-sm text-[#71817a] sm:col-span-2 xl:col-span-4">There are no featured universities yet. Browse all active listings instead.</div>
                @endforelse
            </div>
        </section>

        <section id="top-countries">
            <div class="flex items-end justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[.14em] text-[#b96748]">Where to study</p><h2 class="mt-2 text-2xl font-semibold text-[#183b36]">Explore destinations</h2></div><a href="{{ route('search') }}" class="text-sm font-bold text-[#174f46]">All universities →</a></div>
            <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($topCountries as $country)
                    <a href="{{ route('public.destinations.show', $country->slug) }}" class="flex items-center gap-3 rounded-2xl border border-[#e5e5dc] bg-white p-4 transition hover:border-[#b8cabb] hover:shadow-sm">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#eef2e9] text-sm font-bold text-[#38665a]">@if($country->flag_path)<img src="{{ asset('storage/' . ltrim($country->flag_path, '/')) }}" alt="" class="h-full w-full object-cover">@else{{ mb_substr($country->name, 0, 1) }}@endif</span>
                        <span class="font-semibold text-[#183b36]">{{ $country->name }}</span><span class="ml-auto text-[#819087]" aria-hidden="true">→</span>
                    </a>
                @empty
                    <p class="text-sm text-[#71817a]">Destination listings will appear here when available.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
