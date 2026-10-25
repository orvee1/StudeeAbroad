<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/exfreelance-logo-cropped.jpeg') }}">
    <title>{{ config('app.name', 'EXFREELANCE') }} — University search</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="top" class="brand-theme min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ config('app.name') }} home">
                <x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" />
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
                    <p id="results-count" class="text-sm text-slate-500">Showing {{ $universities->count() }} of {{ number_format($universities->total()) }}</p>
                </div>
                <div id="university-results" class="mt-5 space-y-4">
                    @if ($universities->isNotEmpty())
                        @include('client.partials.search-results', ['universities' => $universities])
                    @else
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#edf4eb] text-xl text-[#174f46]" aria-hidden="true">⌕</span>
                            <h3 class="mt-4 text-lg font-bold">No universities match these filters</h3>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">Try a different destination or clear a filter to see more options.</p>
                            <a href="{{ route('search') }}" class="mt-5 inline-flex rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear filters</a>
                        </div>
                    @endif
                </div>
                <div id="load-more-sentinel" class="mt-7 flex min-h-10 items-center justify-center text-sm text-slate-500" aria-live="polite">{{ $universities->hasMorePages() ? 'Scroll to load more universities' : 'You have reached the end of the results' }}</div>
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
            const results = document.getElementById('university-results');
            const sentinel = document.getElementById('load-more-sentinel');
            const resultsCount = document.getElementById('results-count');
            let nextPageUrl = @json($universities->nextPageUrl());
            let loadedCount = {{ $universities->count() }};
            const totalCount = {{ $universities->total() }};
            let loading = false;
            if (nextPageUrl && 'IntersectionObserver' in window) {
                const observer = new IntersectionObserver(async entries => {
                    if (!entries.some(entry => entry.isIntersecting) || loading || !nextPageUrl) return;
                    loading = true;
                    sentinel.textContent = 'Loading universities?';
                    try {
                        const response = await fetch(nextPageUrl, { headers: { Accept: 'application/json' } });
                        if (!response.ok) throw new Error('Unable to load more universities');
                        const page = await response.json();
                        results.insertAdjacentHTML('beforeend', page.html);
                        loadedCount += (page.html.match(/<article\b/g) || []).length;
                        resultsCount.textContent = `Showing ${loadedCount} of ${new Intl.NumberFormat().format(totalCount)}`;
                        nextPageUrl = page.next_page_url;
                        sentinel.textContent = nextPageUrl ? 'Scroll to load more universities' : 'You have reached the end of the results';
                        if (!nextPageUrl) observer.disconnect();
                    } catch (error) {
                        sentinel.textContent = 'Could not load more universities. Scroll to try again.';
                    } finally { loading = false; }
                }, { rootMargin: '300px' });
                observer.observe(sentinel);
            }
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
