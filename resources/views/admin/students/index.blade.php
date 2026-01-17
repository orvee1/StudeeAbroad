@extends('admin.layouts.app')

@section('page_title', 'Registered Students')
@section('breadcrumb', 'Admin / Students')

@section('content')

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-4 lg:p-6 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <div>
                <div class="text-sm text-slate-500">Users</div>
                <div class="text-xl font-semibold">Registered Students</div>
            </div>
            <div class="text-sm text-slate-500">Total: <span
                    class="font-semibold text-slate-900">{{ $students->total() }}</span></div>
        </div>

        <div class="p-4 lg:p-6 border-b border-slate-200">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-3" method="GET" action="{{ route('students.index') }}">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Search</label>
                    <input name="q" value="{{ $q ?? '' }}" placeholder="name / email / phone..."
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
                    <a href="{{ route('students.index') }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">Student</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Joined</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $s)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $s->name }}</div>
                                <div class="text-xs text-slate-500">{{ $s->email }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $s->phone ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $s->created_at?->format('d M, Y') }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                {{ $s->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $s->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-10 text-center text-slate-500" colspan="4">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $students->links() }}
        </div>
    </div>

@endsection
