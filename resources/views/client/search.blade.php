<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Studee Abroad') }} — University search</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ config('app.name') }} home">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#174f46] text-sm font-bold text-white">SA</span>
                <span><span class="block text-sm font-bold tracking-tight">{{ config('app.name', 'Studee Abroad') }}</span><span class="block text-xs text-slate-500">Find your next campus</span></span>
            </a>
            <nav class="flex items-center gap-2 sm:gap-3" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="hidden rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 sm:inline-flex">Home</a>
                <a href="{{ route('public.programs.index') }}" class="hidden rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 md:inline-flex">Programs</a>
                @guest
                    <a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#103e37]">Create account</a>
                @else
                    <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('student.dashboard') }}" class="rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#103e37]">My dashboard</a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <div class="mb-8 max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#174f46]">Your next chapter starts here</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Find a university that fits your plans</h1>
            <p class="mt-3 text-base leading-7 text-slate-600">Explore verified listings by destination, tuition range and study level. Refine your search to focus on the options that matter to you.</p>
        </div>

        <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">
            <aside class="lg:sticky lg:top-24 lg:col-span-4 xl:col-span-3">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div><h2 class="text-lg font-bold">Refine your search</h2><p class="mt-1 text-sm text-slate-500">Choose one or more filters</p></div>
                        <a href="{{ route('search') }}" class="text-sm font-semibold text-[#174f46] hover:text-[#0d352f]">Reset</a>
                    </div>
                    <form method="GET" action="{{ route('search') }}" class="mt-6 space-y-4">
                        <div>
                            <label for="q" class="text-sm font-semibold text-slate-700">University or keyword</label>
                            <input id="q" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Try a university name" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]">
                        </div>
                        <div>
                            <label for="country_id" class="text-sm font-semibold text-slate-700">Country</label>
                            <select name="country_id" id="country_id" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]">
                                <option value="">All countries</option>
                                @foreach ($countries as $c)<option value="{{ $c->id }}" @selected(($filters['country_id'] ?? null) == $c->id)>{{ $c->name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label for="state_id" class="text-sm font-semibold text-slate-700">State / region</label><select name="state_id" id="state_id" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any</option>@foreach ($states as $s)<option value="{{ $s->id }}" @selected(($filters['state_id'] ?? null) == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
                            <div><label for="city_id" class="text-sm font-semibold text-slate-700">City</label><select name="city_id" id="city_id" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any</option>@foreach ($cities as $ct)<option value="{{ $ct->id }}" @selected(($filters['city_id'] ?? null) == $ct->id)>{{ $ct->name }}</option>@endforeach</select></div>
                        </div>
                        <fieldset>
                            <legend class="text-sm font-semibold text-slate-700">Annual tuition</legend>
                            <div class="mt-1.5 grid grid-cols-2 gap-3"><div><label for="tuition_min" class="sr-only">Minimum tuition</label><input id="tuition_min" type="number" min="0" name="tuition_min" value="{{ $filters['tuition_min'] ?? '' }}" placeholder="Min" class="w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div><div><label for="tuition_max" class="sr-only">Maximum tuition</label><input id="tuition_max" type="number" min="0" name="tuition_max" value="{{ $filters['tuition_max'] ?? '' }}" placeholder="Max" class="w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"></div></div>
                        </fieldset>
                        <div class="grid grid-cols-2 gap-3">
                            <div><label for="level" class="text-sm font-semibold text-slate-700">Study level</label><select id="level" name="level" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any level</option>@foreach ($levels as $level)<option value="{{ $level }}" @selected(($filters['level'] ?? '') === $level)>{{ $level }}</option>@endforeach</select></div>
                            <div><label for="intake" class="text-sm font-semibold text-slate-700">Intake</label><select id="intake" name="intake" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="">Any time</option>@foreach ($intakes as $month)<option value="{{ $month }}" @selected(($filters['intake'] ?? '') === $month)>{{ $month }}</option>@endforeach</select></div>
                        </div>
                        <div><label for="sort" class="text-sm font-semibold text-slate-700">Sort results</label><select id="sort" name="sort" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-[#4e8273] focus:ring-[#4e8273]"><option value="relevance" @selected(($filters['sort'] ?? 'relevance') === 'relevance')>Recommended</option><option value="ranking" @selected(($filters['sort'] ?? '') === 'ranking')>World ranking</option><option value="tuition_low" @selected(($filters['sort'] ?? '') === 'tuition_low')>Tuition: low to high</option><option value="tuition_high" @selected(($filters['sort'] ?? '') === 'tuition_high')>Tuition: high to low</option></select></div>
                        <button type="submit" class="w-full rounded-xl bg-[#174f46] px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#103e37] focus:outline-none focus:ring-2 focus:ring-[#4e8273] focus:ring-offset-2">Show universities</button>
                    </form>
                </div>
            </aside>

            <section class="lg:col-span-8 xl:col-span-9" aria-labelledby="results-heading">
                <div class="flex flex-col justify-between gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-end">
                    <div><p class="text-sm text-slate-500">University directory</p><h2 id="results-heading" class="mt-1 text-2xl font-bold tracking-tight">{{ number_format($universities->total()) }} {{ Str::plural('university', $universities->total()) }} found</h2></div>
                    <p class="text-sm text-slate-500">Page {{ $universities->currentPage() }} of {{ max(1, $universities->lastPage()) }}</p>
                </div>
                <div class="mt-5 space-y-4">
                    @if ($universities->isNotEmpty())
                        @foreach ($universities as $u)
                        <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:border-[#b8cabb] hover:shadow-md">
                            <div class="p-5 sm:p-6">
                                <div class="flex flex-col gap-5 sm:flex-row">
                                    <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 text-2xl font-bold text-[#174f46]">
                                        @if($u->logo_path)<img src="{{ asset('storage/' . ltrim($u->logo_path, '/')) }}" alt="{{ $u->name }} logo" class="h-full w-full object-contain p-2">@else<span aria-hidden="true">{{ mb_substr($u->name, 0, 1) }}</span>@endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-lg font-bold tracking-tight text-slate-950">{{ $u->name }}</h3>
                                            @if ($u->is_featured)<span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800 ring-1 ring-inset ring-amber-200">Featured</span>@endif
                                        </div>
                                        <p class="mt-1 text-sm text-slate-600">{{ collect([$u->city?->name, $u->state?->name, $u->country?->name])->filter()->unique()->implode(', ') ?: 'Location details coming soon' }}</p>
                                        <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $u->short_description ?: 'Explore this university and discover the study opportunities available to you.' }}</p>
                                        <dl class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                                            <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                                <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Annual tuition</dt>
                                                <dd class="mt-1 text-sm font-bold text-slate-900">
                                                    @if ($u->tuition_min !== null || $u->tuition_max !== null)
                                                        {{ $u->cost_currency ?: '' }} {{ $u->tuition_min !== null ? number_format($u->tuition_min) : '—' }}–{{ $u->tuition_max !== null ? number_format($u->tuition_max) : '—' }}
                                                    @else
                                                        Contact university
                                                    @endif
                                                </dd>
                                            </div>
                                            <div class="rounded-2xl bg-slate-50 px-4 py-3"><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">World ranking</dt><dd class="mt-1 text-sm font-bold text-slate-900">{{ $u->world_ranking ? '#' . number_format($u->world_ranking) : 'Not listed' }}</dd></div>
                                            <div class="col-span-2 rounded-2xl bg-slate-50 px-4 py-3 sm:col-span-1"><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Study options</dt><dd class="mt-1 text-sm font-bold text-slate-900">{{ $u->programs_count }} {{ Str::plural('program', $u->programs_count) }}</dd></div>
                                        </dl>
                                        <div class="mt-5 flex flex-wrap items-center gap-3">
                                            <a href="{{ route('public.universities.show', $u->slug) }}" class="inline-flex items-center justify-center rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#103e37]">View university <span class="ml-2" aria-hidden="true">→</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    @else
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#edf4eb] text-xl text-[#174f46]" aria-hidden="true">⌕</span>
                            <h3 class="mt-4 text-lg font-bold">No universities match these filters</h3>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">Try a different destination or clear a filter to see more options.</p>
                            <a href="{{ route('search') }}" class="mt-5 inline-flex rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear filters</a>
                        </div>
                    @endif
                </div>
                @if($universities->hasPages())<nav class="mt-7" aria-label="University results pages">{{ $universities->links() }}</nav>@endif
            </section>
        </div>
    </main>
<x-site-footer />
    <script>
        (() => {
            const country = document.getElementById('country_id');
            const state = document.getElementById('state_id');
            const city = document.getElementById('city_id');
            const selectedState = @json($filters['state_id'] ?? '');
            const selectedCity = @json($filters['city_id'] ?? '');
            async function populate(select, url, selected) {
                select.innerHTML = '<option value="">Any</option>';
                if (!url) return;
                select.disabled = true;
                try {
                    const response = await fetch(url, { headers: { Accept: 'application/json' } });
                    if (!response.ok) throw new Error('Unable to load locations');
                    (await response.json()).forEach(item => {
                        const option = new Option(item.name, item.id, false, String(item.id) === String(selected));
                        select.add(option);
                    });
                } catch (error) {
                    select.add(new Option('Unable to load options', ''));
                } finally { select.disabled = false; }
            }
            country?.addEventListener('change', async () => { await populate(state, country.value ? `{{ route('api.states') }}?country_id=${encodeURIComponent(country.value)}` : '', ''); await populate(city, '', ''); });
            state?.addEventListener('change', () => populate(city, state.value ? `{{ route('api.cities') }}?state_id=${encodeURIComponent(state.value)}` : '', ''));
            if (country?.value && state?.options.length <= 1) populate(state, `{{ route('api.states') }}?country_id=${encodeURIComponent(country.value)}`, selectedState).then(() => { if (state.value) populate(city, `{{ route('api.cities') }}?state_id=${encodeURIComponent(state.value)}`, selectedCity); });
        })();
    </script>
</body>
</html>
