@extends('admin.layouts.app')

@section('page_title', 'Cities')
@section('breadcrumb', 'Admin / Cities')

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
                    <div class="text-sm text-slate-500">Manage cities</div>
                    <div class="text-xl font-semibold">All Cities</div>
                </div>

                <a href="{{ route('cities.create') }}"
                    class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                    + Add City
                </a>
            </div>

            <form class="mt-4 grid grid-cols-1 md:grid-cols-5 gap-3" method="GET" action="{{ route('cities.index') }}">
                <div>
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="name / slug..."
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
                    <label class="text-xs text-slate-500">Status</label>
                    <select name="is_active"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        <option value="1" @selected(($isActive ?? '') === '1')>Active</option>
                        <option value="0" @selected(($isActive ?? '') === '0')>Inactive</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Filter</button>
                    <a href="{{ route('cities.index') }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">City</th>
                        <th class="px-6 py-3">State</th>
                        <th class="px-6 py-3">Country</th>
                        <th class="px-6 py-3">Coordinates</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($cities as $city)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $city->name }}</div>
                                <div class="text-xs text-slate-500">{{ $city->slug }}</div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $city->state?->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $city->state?->country?->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                <div>{{ $city->latitude ?? '—' }}, {{ $city->longitude ?? '—' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                {{ $city->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $city->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('cities.show', $city) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">View</a>

                                    <a href="{{ route('cities.edit', $city) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Edit</a>

                                    <form method="POST" action="{{ route('cities.destroy', $city) }}"
                                        onsubmit="return confirm('Delete this city?')">
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
                            <td class="px-6 py-10 text-center text-slate-500" colspan="6">No cities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $cities->links() }}
        </div>
    </div>

    {{-- Dependent dropdown: country -> states --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countrySel = document.getElementById('filter_country_id');
            const stateSel = document.getElementById('filter_state_id');

            if (!countrySel || !stateSel) return;

            countrySel.addEventListener('change', async () => {
                const countryId = countrySel.value;

                // reset state
                stateSel.innerHTML = `<option value="">All</option>`;

                if (!countryId) return;

                const url = `{{ route('api.statesByCountry') }}?country_id=${countryId}`;
                const res = await fetch(url);
                const states = await res.json();

                states.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.name;
                    stateSel.appendChild(opt);
                });
            });
        });
    </script>

@endsection
