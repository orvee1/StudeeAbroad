@extends('admin.layouts.app')

@section('page_title', 'Success Stories')
@section('breadcrumb', 'Admin / Success Stories')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-4 lg:p-6 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <div>
                <div class="text-sm text-slate-500">Manage</div>
                <div class="text-xl font-semibold">Success Stories</div>
                <div class="text-sm text-slate-600 mt-1">Create stories, upload redacted student evidence, and choose what appears on the homepage.</div>
            </div>
            <a href="{{ route('success_stories.create') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">Add success story</a>
        </div>

        <div class="p-4 lg:p-6 border-b border-slate-200">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-3" method="GET"
                action="{{ route('success_stories.index') }}">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="name / from / destination..."
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
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Filter</button>
                    <a href="{{ route('success_stories.index') }}"
                        class="px-4 py-2 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">Student</th>
                        <th class="px-6 py-3">Destination</th>
                        <th class="px-6 py-3">Badge</th>
                        <th class="px-6 py-3">Evidence</th>
                        <th class="px-6 py-3">Sort</th>
                        <th class="px-6 py-3">Active</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($stories as $s)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                        @if ($s->photo_path)
                                            <img class="h-10 w-10 object-cover" src="{{ asset('storage/' . $s->photo_path) }}"
                                                alt="">
                                        @else
                                            <span class="text-[10px] text-slate-500">Photo</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-slate-900 truncate">{{ $s->name }}</div>
                                        <div class="text-xs text-slate-500 truncate">{{ $s->from ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $s->destination ?? '—' }}</div>
                                <div class="text-xs text-slate-500 line-clamp-1">“{{ $s->story }}”</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-slate-900">{{ $s->badge ?? '—' }}</div>
                                <div class="text-xs text-slate-500">{{ $s->year ?? '' }} @if ($s->score)
                                        • {{ $s->score }}
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-600">{{ $s->media_count }} image{{ (int) $s->media_count === 1 ? '' : 's' }}</td>

                            {{-- Inline update (sort + active) --}}
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('success_stories.moderate', $s) }}"
                                    class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="sort_order" value="{{ $s->sort_order }}"
                                        class="w-24 rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                                    <input type="hidden" name="is_active" value="{{ $s->is_active ? 1 : 0 }}">
                                    <button class="px-3 py-2 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">
                                        Save
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('success_stories.moderate', $s) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="sort_order" value="{{ $s->sort_order }}">
                                    <input type="hidden" name="is_active" value="{{ $s->is_active ? 0 : 1 }}">
                                    <button
                                        class="inline-flex items-center px-3 py-2 rounded-xl text-sm border
                                    {{ $s->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                        {{ $s->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('success_stories.edit', $s) }}" class="rounded-xl border px-3 py-2 text-sm font-semibold border-slate-300 bg-slate-50 text-slate-800 shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">Edit</a>
                                    <form method="POST" action="{{ route('success_stories.destroy', $s) }}"
                                        onsubmit="return confirm('Delete this story and its uploaded images?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-2 rounded-xl border text-rose-700 text-sm bg-rose-50 border-rose-300 font-semibold shadow-sm transition hover:bg-rose-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-2">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-10 text-center text-slate-500" colspan="7">No success stories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $stories->links() }}
        </div>
    </div>
@endsection
