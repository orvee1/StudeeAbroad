@extends('admin.layouts.app')

@section('page_title', 'Administrators')
@section('breadcrumb', 'Admin / Administrators')

@section('content')
    @if (session('success'))
        <div role="status" class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-col justify-between gap-3 border-b border-slate-200 p-4 lg:flex-row lg:items-center lg:p-6">
            <div>
                <div class="text-sm text-slate-500">Admin access</div>
                <h1 class="text-xl font-semibold">Administrators</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-sm text-slate-500">Total: <span class="font-semibold text-slate-900">{{ $admins->total() }}</span></div>
                <a href="{{ route('admins.create') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm text-white hover:opacity-90">
                    + Create Admin
                </a>
            </div>
        </div>

        <form class="grid grid-cols-1 gap-3 border-b border-slate-200 p-4 md:grid-cols-[1fr_auto_auto] lg:p-6" method="GET" action="{{ route('admins.index') }}">
            <div>
                <label for="q" class="text-xs text-slate-500">Search administrators</label>
                <input id="q" name="q" value="{{ $q }}" placeholder="name or email..."
                    class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
            </div>
            <button class="self-end rounded-xl bg-slate-900 px-4 py-2 text-sm text-white hover:opacity-90">Search</button>
            <a href="{{ route('admins.index') }}" class="self-end rounded-xl border px-4 py-2 text-center text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">Reset</a>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr class="text-left">
                        <th class="px-6 py-3">Administrator</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admins as $admin)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $admin->name }}</div>
                                <div class="text-xs text-slate-500">{{ $admin->email }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $admin->phone ?: '—' }}</td>
                            <td class="px-6 py-4">{{ $admin->created_at?->format('d M, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-10 text-center text-slate-500" colspan="3">No administrators found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 p-4 lg:p-6">
            {{ $admins->links() }}
        </div>
    </div>
@endsection
