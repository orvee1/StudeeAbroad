@extends('admin.layouts.app')

@section('page_title', 'States')
@section('breadcrumb', 'Admin / States')

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
                    <div class="text-sm text-slate-500">Manage states</div>
                    <div class="text-xl font-semibold">All States</div>
                </div>

                <a href="{{ route('states.create') }}"
                    class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                    + Add State
                </a>
            </div>

            <form class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-3" method="GET"
                action="{{ route('states.index') }}">
                <div>
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="name / slug / code..."
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                </div>

                <div>
                    <label class="text-xs text-slate-500">Country</label>
                    <select name="country_id"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        @foreach ($countries as $c)
                            <option value="{{ $c->id }}" @selected((string) $countryId === (string) $c->id)>{{ $c->name }}</option>
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
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Filter
                    </button>
                    <a href="{{ route('states.index') }}"
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
                        <th class="px-6 py-3">State</th>
                        <th class="px-6 py-3">Country</th>
                        <th class="px-6 py-3">Code</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($states as $st)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $st->name }}</div>
                                <div class="text-xs text-slate-500">{{ $st->slug }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-slate-800">{{ $st->country?->name ?? '—' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $st->code ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                {{ $st->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $st->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('states.show', $st) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                                        View
                                    </a>
                                    <a href="{{ route('states.edit', $st) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('states.destroy', $st) }}"
                                        onsubmit="return confirm('Delete this state?')">
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
                                No states found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $states->links() }}
        </div>
    </div>

@endsection
