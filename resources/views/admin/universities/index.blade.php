@extends('layouts.app')

@section('page_title', 'Universities')
@section('breadcrumb', 'Admin / Universities')

@section('content')

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-4 lg:p-6 border-b border-slate-200">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3 justify-between">
                <div>
                    <div class="text-sm text-slate-500">Manage universities</div>
                    <div class="text-xl font-semibold">All Universities</div>
                </div>

                <a href="{{ route('universities.create') }}"
                    class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                    + Add University
                </a>
            </div>

            <form class="mt-4 grid grid-cols-1 md:grid-cols-6 gap-3" method="GET"
                action="{{ route('universities.index') }}">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="name / slug / email / website..."
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                </div>

                <div>
                    <label class="text-xs text-slate-500">Country</label>
                    <select id="filter_country_id" name="country_id"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        @foreach ($countries as $c)
                            <option value="{{ $c->id }}" @selected((string) $countryId === (string) $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs text-slate-500">State</label>
                    <select id="filter_state_id" name="state_id"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        @foreach ($states as $s)
                            <option value="{{ $s->id }}" @selected((string) $stateId === (string) $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs text-slate-500">City</label>
                    <select id="filter_city_id" name="city_id"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        @foreach ($cities as $c)
                            <option value="{{ $c->id }}" @selected((string) $cityId === (string) $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs text-slate-500">Status</label>
                    <select name="is_active"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        <option value="1" @selected(($isActive ?? '') === '1')>Active</option>
                        <option value="0" @selected(($isActive ?? '') === '0')>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs text-slate-500">Featured</label>
                    <select name="is_featured"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        <option value="1" @selected(($isFeatured ?? '') === '1')>Featured</option>
                        <option value="0" @selected(($isFeatured ?? '') === '0')>Not Featured</option>
                    </select>
                </div>

                <div class="flex items-end gap-2 md:col-span-6">
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Filter</button>
                    <a href="{{ route('universities.index') }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">University</th>
                        <th class="px-6 py-3">Location</th>
                        <th class="px-6 py-3">Ranking</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($universities as $u)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                                        @if ($u->logo_path)
                                            <img class="h-10 w-10 object-cover" src="{{ asset('storage/' . $u->logo_path) }}"
                                                alt="">
                                        @else
                                            <span class="text-[10px] text-slate-500">Logo</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold truncate">{{ $u->name }}</div>
                                        <div class="text-xs text-slate-500 truncate">{{ $u->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-slate-800">
                                    {{ $u->city?->name ?? '—' }}, {{ $u->state?->name ?? '—' }}
                                </div>
                                <div class="text-xs text-slate-500">{{ $u->country?->name ?? '—' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div>{{ $u->world_ranking ? '#' . $u->world_ranking : '—' }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $u->acceptance_rate !== null ? $u->acceptance_rate . '% acc.' : '' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                    {{ $u->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                        {{ $u->is_active ? 'Active' : 'Inactive' }}
                                    </span>

                                    @if ($u->is_featured)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-900 text-white">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('universities.show', $u) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">View</a>

                                    <a href="{{ route('universities.edit', $u) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Edit</a>

                                    <form method="POST" action="{{ route('universities.destroy', $u) }}"
                                        onsubmit="return confirm('Delete this university?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-2 rounded-xl border border-rose-200 text-rose-700 text-sm hover:bg-rose-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-10 text-center text-slate-500" colspan="5">No universities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $universities->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countrySel = document.getElementById('filter_country_id');
            const stateSel = document.getElementById('filter_state_id');
            const citySel = document.getElementById('filter_city_id');

            async function loadStates(countryId, keepValue = '') {
                stateSel.innerHTML = `<option value="">All</option>`;
                citySel.innerHTML = `<option value="">All</option>`;
                if (!countryId) return;

                const url = `{{ route('api.statesByCountry') }}?country_id=${countryId}`;
                const res = await fetch(url);
                const items = await res.json();

                items.forEach(i => {
                    const opt = document.createElement('option');
                    opt.value = i.id;
                    opt.textContent = i.name;
                    if (String(keepValue) === String(i.id)) opt.selected = true;
                    stateSel.appendChild(opt);
                });
            }

            async function loadCities(stateId, keepValue = '') {
                citySel.innerHTML = `<option value="">All</option>`;
                if (!stateId) return;

                const url = `{{ route('api.citiesByState') }}?state_id=${stateId}`;
                const res = await fetch(url);
                const items = await res.json();

                items.forEach(i => {
                    const opt = document.createElement('option');
                    opt.value = i.id;
                    opt.textContent = i.name;
                    if (String(keepValue) === String(i.id)) opt.selected = true;
                    citySel.appendChild(opt);
                });
            }

            if (countrySel) {
                countrySel.addEventListener('change', () => loadStates(countrySel.value));
            }
            if (stateSel) {
                stateSel.addEventListener('change', () => loadCities(stateSel.value));
            }
        });
    </script>

@endsection
