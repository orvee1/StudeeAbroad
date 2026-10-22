<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Study programs | {{ config('app.name', 'Studee Abroad') }}</title>
    <meta name="description" content="Search international university programs by destination, degree level, subject, tuition and intake.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="brand-theme bg-[#fbf9f4] font-sans text-[#183b36] antialiased">
    <header class="border-b border-[#e8e5db] bg-white"><div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8"><a href="{{ route('home') }}" class="flex items-center gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#174f46] text-xs font-bold text-white">SA</span><span><strong class="block text-sm">{{ config('app.name', 'Studee Abroad') }}</strong><span class="text-xs text-[#819087]">Your study-abroad guide</span></span></a><nav class="flex items-center gap-4 text-sm"><a href="{{ route('search') }}" class="hidden font-semibold text-[#52665f] sm:inline">Universities</a>@auth<a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-[#174f46] px-4 py-2.5 font-semibold text-white">Dashboard</a>@else<a href="{{ route('login') }}" class="font-semibold text-[#52665f]">Log in</a>@endauth</nav></div></header>
    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <nav class="text-sm text-[#819087]" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-[#174f46]">Home</a><span class="mx-2">/</span><span>Programs</span></nav>
        <div class="mt-6 max-w-3xl"><p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">Find your subject</p><h1 class="mt-2 text-4xl font-semibold tracking-tight sm:text-5xl">Explore study programs</h1><p class="mt-4 text-base leading-7 text-[#687871]">Compare degree level, destination, tuition and intake using programs currently listed in our university directory.</p></div>
        <div class="mt-8 grid items-start gap-6 lg:grid-cols-[18rem_1fr]">
            <aside class="rounded-2xl border border-[#e6e5dc] bg-white p-5 lg:sticky lg:top-24"><div class="flex items-center justify-between"><div><h2 class="font-bold">Filters</h2><p class="mt-1 text-xs text-[#819087]">Narrow your options</p></div><a href="{{ route('public.programs.index') }}" class="text-xs font-bold text-[#174f46]">Reset</a></div>
                <form method="GET" action="{{ route('public.programs.index') }}" class="mt-5 space-y-4">
                    <div><label for="program-q" class="text-sm font-semibold">Program or subject</label><input id="program-q" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="e.g. computer science" class="mt-1.5 w-full rounded-xl border-[#dfe5df] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div>
                    <div><label for="program-country" class="text-sm font-semibold">Destination</label><select id="program-country" name="country_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any country</option>@foreach($countries as $country)<option value="{{ $country->id }}" @selected(($filters['country_id'] ?? '') == $country->id)>{{ $country->name }}</option>@endforeach</select></div>
                    <div><label for="program-level" class="text-sm font-semibold">Study level</label><select id="program-level" name="level" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any level</option>@foreach($levels as $level)<option value="{{ $level }}" @selected(($filters['level'] ?? '') === $level)>{{ $level }}</option>@endforeach</select></div>
                    <div><label for="program-field" class="text-sm font-semibold">Subject area</label><select id="program-field" name="field" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any subject</option>@foreach($fields as $field)<option value="{{ $field }}" @selected(($filters['field'] ?? '') === $field)>{{ $field }}</option>@endforeach</select></div>
                    <div><label for="program-intake" class="text-sm font-semibold">Intake</label><select id="program-intake" name="intake" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any intake</option>@foreach($intakes as $intake)<option value="{{ $intake }}" @selected(($filters['intake'] ?? '') === $intake)>{{ $intake }}</option>@endforeach</select></div>
                    <div><p class="text-sm font-semibold">Estimated annual tuition</p><div class="mt-1.5 grid grid-cols-2 gap-2"><div><label for="tuition-min" class="sr-only">Minimum annual tuition</label><input id="tuition-min" type="number" min="0" name="tuition_min" value="{{ $filters['tuition_min'] ?? '' }}" placeholder="Min" class="w-full rounded-xl border-[#dfe5df] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div><div><label for="tuition-max" class="sr-only">Maximum annual tuition</label><input id="tuition-max" type="number" min="0" name="tuition_max" value="{{ $filters['tuition_max'] ?? '' }}" placeholder="Max" class="w-full rounded-xl border-[#dfe5df] text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div></div></div>
                    <div><label for="program-sort" class="text-sm font-semibold">Sort by</label><select id="program-sort" name="sort" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="relevance" @selected(($filters['sort'] ?? 'relevance') === 'relevance')>Recommended</option><option value="tuition_low" @selected(($filters['sort'] ?? '') === 'tuition_low')>Tuition: low to high</option><option value="tuition_high" @selected(($filters['sort'] ?? '') === 'tuition_high')>Tuition: high to low</option></select></div>
                    <button class="w-full rounded-xl bg-[#174f46] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#103e37]">Show programs</button>
                </form>
            </aside>
            <section aria-labelledby="program-results-heading"><div class="flex flex-col gap-2 border-b border-[#e5e5dc] pb-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-sm text-[#819087]">Program directory</p><h2 id="program-results-heading" class="mt-1 text-2xl font-semibold">{{ number_format($programs->total()) }} {{ Str::plural('program', $programs->total()) }} found</h2></div><p class="text-xs text-[#819087]">Page {{ $programs->currentPage() }} of {{ max(1, $programs->lastPage()) }}</p></div>
                <div class="mt-5 space-y-3">
                    @forelse($programs as $program)
                        <a href="{{ route('public.programs.show', ['university' => $program->university->slug, 'program' => $program->slug]) }}" class="group block rounded-2xl border border-[#e6e5dc] bg-white p-5 transition hover:border-[#b8cabb] hover:shadow-md sm:p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-wide text-[#b96748]">{{ $program->level }} @if($program->field)· {{ $program->field }}@endif</p>
                                    <h3 class="mt-2 text-lg font-bold text-[#183b36]">{{ $program->title }}</h3>
                                    <p class="mt-1 text-sm text-[#687871]">{{ $program->university->name }}</p>
                                    <p class="mt-1 text-xs text-[#819087]">{{ collect([$program->university->city?->name, $program->university->country?->name])->filter()->implode(', ') }}</p>
                                </div>
                                <div class="shrink-0 sm:text-right">
                                    <p class="text-[11px] font-semibold uppercase tracking-wide text-[#91a097]">Tuition estimate</p>
                                    <p class="mt-1 text-sm font-bold text-[#345c50]">
                                        @php
                                            $annualMin = $program->tuition_per_year_min ?? ($program->tuition_per_semester_min !== null && $program->semesters_per_year ? $program->tuition_per_semester_min * $program->semesters_per_year : null);
                                            $annualMax = $program->tuition_per_year_max ?? ($program->tuition_per_semester_max !== null && $program->semesters_per_year ? $program->tuition_per_semester_max * $program->semesters_per_year : null);
                                        @endphp
                                        @if ($annualMin !== null || $annualMax !== null)
                                            {{ $program->university->country?->currency ? $program->university->country->currency . ' ' : '' }}{{ $annualMin !== null ? number_format($annualMin) : '—' }}–{{ $annualMax !== null ? number_format($annualMax) : '—' }} <span class="font-normal text-[#819087]">/ year</span>
                                        @else
                                            Ask university
                                        @endif
                                    </p>
                                    @if ($program->tuition_per_semester_min !== null || $program->tuition_per_semester_max !== null)
                                        <p class="mt-1 text-xs text-[#71817a]">{{ $program->university->country?->currency ? $program->university->country->currency . ' ' : '' }}{{ $program->tuition_per_semester_min !== null ? number_format($program->tuition_per_semester_min) : '—' }}–{{ $program->tuition_per_semester_max !== null ? number_format($program->tuition_per_semester_max) : '—' }} / semester · {{ $program->semesters_per_year }} {{ Str::plural('semester', $program->semesters_per_year) }} per year</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 border-t border-[#eeeee8] pt-4 text-xs text-[#71817a]">
                                @if ($program->duration_months)<span class="rounded-full bg-[#f2f0e8] px-2.5 py-1">{{ $program->duration_months }} months</span>@endif
                                @if ($program->language)<span class="rounded-full bg-[#f2f0e8] px-2.5 py-1">{{ $program->language }}</span>@endif
                                @foreach ($program->intake_months ?? [] as $intake)<span class="rounded-full bg-[#edf4eb] px-2.5 py-1">{{ $intake }}</span>@endforeach
                            </div>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-[#d5ddd2] bg-white px-6 py-12 text-center"><h3 class="font-bold">No programs match those filters</h3><p class="mt-2 text-sm text-[#71817a]">Try a different destination or clear a filter.</p><a href="{{ route('public.programs.index') }}" class="mt-4 inline-flex rounded-xl border border-[#d5ddd2] px-4 py-2 text-sm font-semibold">Clear filters</a></div>
                    @endforelse
                </div>
                @if($programs->hasPages())<nav class="mt-6" aria-label="Program result pages">{{ $programs->links() }}</nav>@endif
            </section>
        </div>
    </main>
<x-site-footer />
</body>
</html>
