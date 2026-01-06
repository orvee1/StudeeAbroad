@extends('admin.layouts.app')

@section('page_title', 'Countries')
@section('breadcrumb', 'Admin / Countries')

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
                    <div class="text-sm text-slate-500">Manage countries</div>
                    <div class="text-xl font-semibold">All Countries</div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('countries.create') }}"
                        class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        + Add Country
                    </a>
                </div>
            </div>

            <form class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3" method="GET"
                action="{{ route('countries.index') }}">
                <div>
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="name / slug / iso / currency..."
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
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
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Filter
                    </button>
                    <a href="{{ route('countries.index') }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">Country</th>
                        <th class="px-6 py-3">ISO</th>
                        <th class="px-6 py-3">Currency</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($countries as $country)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                                        @if ($country->flag_path)
                                            <img class="h-10 w-10 object-cover"
                                                src="{{ asset('storage/' . $country->flag_path) }}" alt="">
                                        @else
                                            <span class="text-[10px] text-slate-500">No Flag</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold">{{ $country->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $country->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-slate-800">{{ $country->iso2 ?? '—' }} / {{ $country->iso3 ?? '—' }}</div>
                                <div class="text-xs text-slate-500">Phone: {{ $country->phone_code ?? '—' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-slate-800">{{ $country->currency ?? '—' }}</div>
                                <div class="text-xs text-slate-500">Sort: {{ $country->sort_order }}</div>
                            </td>

                            <td class="px-6 py-4">
                                @if ($country->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-50 text-amber-700 border border-amber-200">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('countries.show', $country) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                                        View
                                    </a>

                                    <a href="{{ route('countries.edit', $country) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('countries.destroy', $country) }}"
                                        onsubmit="return confirm('Delete this country?')">
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
                            <td class="px-6 py-10 text-center text-slate-500" colspan="5">
                                No countries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $countries->links() }}
        </div>
    </div>

@endsection
