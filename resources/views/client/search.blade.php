<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Studee Abroad') }} — Search</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    <div class="border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-2xl bg-slate-900"></div>
                <div>
                    <div class="text-sm font-semibold">{{ config('app.name', 'Studee Abroad') }}</div>
                    <div class="text-xs text-slate-500">Search Universities</div>
                </div>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}"
                    class="px-3 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-sm">
                    Back
                </a>
                @guest
                    <a href="{{ route('login') }}"
                        class="px-3 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Login
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Filters --}}
            <aside class="lg:col-span-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 sticky top-24">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold">Filters</div>
                        <a href="{{ route('search') }}" class="text-sm text-slate-600 hover:text-slate-900">Reset</a>
                    </div>

                    <form method="GET" action="{{ route('search') }}" class="mt-4 space-y-4">
                        <div>
                            <label class="text-xs text-slate-500">Keyword</label>
                            <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="University name..."
                                class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Country</label>
                                <select name="country_id" id="country_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                    @foreach ($countries as $c)
                                        <option value="{{ $c->id }}" @selected(($filters['country_id'] ?? null) == $c->id)>
                                            {{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500">State</label>
                                <select name="state_id" id="state_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                    @foreach ($states as $s)
                                        <option value="{{ $s->id }}" @selected(($filters['state_id'] ?? null) == $s->id)>
                                            {{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs text-slate-500">City</label>
                            <select name="city_id" id="city_id"
                                class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                <option value="">Any</option>
                                @foreach ($cities as $ct)
                                    <option value="{{ $ct->id }}" @selected(($filters['city_id'] ?? null) == $ct->id)>
                                        {{ $ct->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Tuition Min</label>
                                <input type="number" name="tuition_min" value="{{ $filters['tuition_min'] ?? '' }}"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500">Tuition Max</label>
                                <input type="number" name="tuition_max" value="{{ $filters['tuition_max'] ?? '' }}"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Level</label>
                                <select name="level"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                    @foreach ($levels as $lvl)
                                        <option value="{{ $lvl }}" @selected(($filters['level'] ?? null) === $lvl)>
                                            {{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-slate-500">Intake</label>
                                <select name="intake"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                    @foreach ($intakes as $m)
                                        <option value="{{ $m }}" @selected(($filters['intake'] ?? null) === $m)>
                                            {{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Sort</label>
                                <select name="sort"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="relevance" @selected(($filters['sort'] ?? 'relevance') === 'relevance')>Relevance</option>
                                    <option value="ranking" @selected(($filters['sort'] ?? null) === 'ranking')>Ranking</option>
                                    <option value="tuition_low" @selected(($filters['sort'] ?? null) === 'tuition_low')>Tuition: Low</option>
                                    <option value="tuition_high" @selected(($filters['sort'] ?? null) === 'tuition_high')>Tuition: High</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-slate-500">Per page</label>
                                <select name="per_page"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    @foreach ([12, 18, 24, 36] as $pp)
                                        <option value="{{ $pp }}" @selected(($filters['per_page'] ?? 12) == $pp)>
                                            {{ $pp }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Results --}}
            <main class="lg:col-span-8">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <div class="text-sm text-slate-500">Results</div>
                        <div class="text-xl font-bold">{{ $universities->total() }} Universities found</div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($universities as $u)
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">{{ $u->name }}</div>
                                    <div class="text-sm text-slate-600 mt-1 truncate">
                                        {{ $u->city_id ? 'City #' . $u->city_id : '—' }} •
                                        {{ $u->country_id ? 'Country #' . $u->country_id : '—' }}
                                    </div>
                                </div>
                                @if ($u->is_featured)
                                    <span
                                        class="text-[11px] px-2.5 py-1 rounded-full border border-amber-200 bg-amber-50 text-amber-700">Featured</span>
                                @endif
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                    <div class="text-xs text-slate-500">Tuition</div>
                                    <div class="font-semibold mt-1 text-slate-900">
                                        {{ $u->tuition_min ? number_format($u->tuition_min) : '—' }}
                                        -
                                        {{ $u->tuition_max ? number_format($u->tuition_max) : '—' }}
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                    <div class="text-xs text-slate-500">Ranking</div>
                                    <div class="font-semibold mt-1 text-slate-900">
                                        {{ $u->world_ranking ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-sm text-slate-600 line-clamp-2">
                                {{ $u->short_description ?? 'No summary yet.' }}
                            </div>

                            <div class="mt-5 flex gap-2">
                                <button
                                    class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">View
                                    (Next)</button>
                                <button
                                    class="px-4 py-2 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50">Shortlist
                                    (Next)</button>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center text-slate-600">
                            No universities matched your filters.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $universities->links() }}
                </div>
            </main>
        </div>
    </div>

    <script>
        (function() {
            const country = document.getElementById('country_id');
            const state = document.getElementById('state_id');
            const city = document.getElementById('city_id');

            async function loadStates(countryId) {
                if (!state) return;
                state.innerHTML = `<option value="">Any</option>`;
                city.innerHTML = `<option value="">Any</option>`;
                if (!countryId) return;

                const res = await fetch(`{{ route('api.states') }}?country_id=${countryId}`);
                const data = await res.json();
                data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.name;
                    state.appendChild(opt);
                });
            }

            async function loadCities(stateId) {
                if (!city) return;
                city.innerHTML = `<option value="">Any</option>`;
                if (!stateId) return;

                const res = await fetch(`{{ route('api.cities') }}?state_id=${stateId}`);
                const data = await res.json();
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name;
                    city.appendChild(opt);
                });
            }

            if (country) {
                country.addEventListener('change', e => loadStates(e.target.value));
            }
            if (state) {
                state.addEventListener('change', e => loadCities(e.target.value));
            }
        })();
    </script>
</body>

</html>
