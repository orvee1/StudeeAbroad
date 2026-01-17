@extends('admin.layouts.app')

@section('page_title', 'Dashboard')
@section('breadcrumb', 'Admin / Dashboard')

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                [
                    'label' => 'Countries',
                    'value' => $stats['countries'] ?? 0,
                    'route' => route('countries.index'),
                ],
                ['label' => 'States', 'value' => $stats['states'] ?? 0, 'route' => route('states.index')],
                ['label' => 'Cities', 'value' => $stats['cities'] ?? 0, 'route' => route('cities.index')],
                [
                    'label' => 'Universities',
                    'value' => $stats['universities'] ?? 0,
                    'route' => route('universities.index'),
                ],
                [
                    'label' => 'Programs',
                    'value' => $stats['programs'] ?? 0,
                    'route' => route('universities.index'),
                ],
                ['label' => 'Media', 'value' => $stats['media'] ?? 0, 'route' => route('universities.index')],
                ['label' => 'Students', 'value' => $stats['students'] ?? 0, 'route' => route('students.index')],
            ];
        @endphp

        @foreach ($cards as $c)
            <a href="{{ $c['route'] }}" class="bg-white border border-slate-200 rounded-2xl p-5 hover:bg-slate-50">
                <div class="text-xs text-slate-500">{{ $c['label'] }}</div>
                <div class="text-3xl font-bold mt-2">{{ number_format((int) $c['value']) }}</div>
                <div class="mt-2 text-sm text-slate-600">View</div>
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500">Latest</div>
                    <div class="text-lg font-semibold">Registered Students</div>
                </div>
                <a href="{{ route('students.index') }}"
                    class="text-sm px-3 py-2 rounded-xl border border-slate-200 hover:bg-slate-50">All Students</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($latestStudents as $s)
                    <div class="p-5 flex items-center justify-between">
                        <div>
                            <div class="font-semibold">{{ $s->name }}</div>
                            <div class="text-xs text-slate-500">{{ $s->email }} @if ($s->phone)
                                    • {{ $s->phone }}
                                @endif
                            </div>
                            <div class="text-xs text-slate-500 mt-1">Joined: {{ $s->created_at?->format('d M, Y') }}</div>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                        {{ $s->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                            {{ $s->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">No students yet.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500">Highlight</div>
                    <div class="text-lg font-semibold">Featured Universities</div>
                </div>
                <a href="{{ route('universities.index') }}"
                    class="text-sm px-3 py-2 rounded-xl border border-slate-200 hover:bg-slate-50">Manage</a>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($featuredUniversities as $u)
                    <a href="{{ route('universities.show', $u) }}"
                        class="border border-slate-200 rounded-2xl p-4 hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center">
                                @if ($u->logo_path)
                                    <img src="{{ asset('storage/' . $u->logo_path) }}" class="h-full w-full object-cover"
                                        alt="">
                                @else
                                    <span class="text-xs text-slate-500">LOGO</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold truncate">{{ $u->name }}</div>
                                <div class="text-xs text-slate-500 truncate">{{ $u->slug }}</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-2 p-8 text-center text-slate-500">No featured universities.</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection
