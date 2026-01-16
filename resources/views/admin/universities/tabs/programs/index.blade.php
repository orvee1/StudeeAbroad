@extends('layouts.app')

@section('page_title', 'Programs')
@section('breadcrumb', 'Admin / Universities / Programs')

@section('content')

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 bg-white border border-slate-200 rounded-2xl p-3 flex flex-wrap gap-2">
        <a href="{{ route('universities.show', $university) }}"
            class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">
            Overview
        </a>
        <a href="{{ route('universities.programs.index', $university) }}"
            class="px-4 py-2 rounded-xl text-sm border border-slate-200 bg-slate-900 text-white">
            Programs
        </a>
        <a href="{{ route('universities.media.index', $university) }}"
            class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">
            Media
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-4 lg:p-6 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <div>
                <div class="text-sm text-slate-500">University</div>
                <div class="text-xl font-semibold">{{ $university->name }}</div>
            </div>

            <a href="{{ route('universities.programs.create', $university) }}"
                class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                + Add Program
            </a>
        </div>

        <div class="p-4 lg:p-6 border-b border-slate-200">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-3" method="GET"
                action="{{ route('universities.programs.index', $university) }}">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="title / slug / field..."
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                </div>

                <div>
                    <label class="text-xs text-slate-500">Level</label>
                    <select name="level"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        @foreach ($levels as $lv)
                            <option value="{{ $lv }}" @selected(($level ?? '') === $lv)>{{ $lv }}</option>
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

                <div class="md:col-span-4 flex items-end gap-2">
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Filter</button>
                    <a href="{{ route('universities.programs.index', $university) }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">Program</th>
                        <th class="px-6 py-3">Level</th>
                        <th class="px-6 py-3">Tuition</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($programs as $p)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $p->title }}</div>
                                <div class="text-xs text-slate-500">{{ $p->slug }} @if ($p->field)
                                        • {{ $p->field }}
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4">{{ $p->level }}</td>

                            <td class="px-6 py-4">
                                {{ $p->tuition_per_year_min !== null ? number_format($p->tuition_per_year_min) : '—' }}
                                -
                                {{ $p->tuition_per_year_max !== null ? number_format($p->tuition_per_year_max) : '—' }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                {{ $p->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $p->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('universities.programs.edit', [$university, $p]) }}"
                                        class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Edit</a>

                                    <form method="POST"
                                        action="{{ route('universities.programs.destroy', [$university, $p]) }}"
                                        onsubmit="return confirm('Delete this program?')">
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
                            <td class="px-6 py-10 text-center text-slate-500" colspan="5">No programs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $programs->links() }}
        </div>
    </div>

@endsection
