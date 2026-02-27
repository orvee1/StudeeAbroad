@extends('student.layouts.app')

@section('page_title', 'My Success Stories')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="text-sm text-slate-500">Student Portal</div>
                <div class="text-xl font-semibold text-slate-900">My Success Stories</div>
                <div class="text-sm text-slate-600 mt-1">Submit your story. Admin will approve before it shows on the home
                    page.</div>
            </div>

            <a href="{{ route('student.success_stories.create') }}"
                class="px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                + Add Story
            </a>
        </div>

        <div class="p-5">
            @if ($stories->count() === 0)
                <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                    <div class="text-lg font-semibold text-slate-900">No stories yet</div>
                    <div class="text-slate-600 mt-1">Share your success journey and inspire others.</div>
                    <a href="{{ route('student.success_stories.create') }}"
                        class="inline-flex mt-5 px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Create your first story
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($stories as $s)
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">
                                        {{ $s->destination ?? 'Destination not set' }}</div>
                                    <div class="text-sm text-slate-600 mt-1 truncate">
                                        {{ $s->from ?? '—' }}
                                    </div>
                                </div>

                                <span
                                    class="shrink-0 text-[11px] px-2.5 py-1 rounded-full border
                                {{ $s->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $s->is_active ? 'Approved' : 'Pending' }}
                                </span>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @if ($s->badge)
                                    <span
                                        class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">{{ $s->badge }}</span>
                                @endif
                                @if ($s->year)
                                    <span
                                        class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">📅
                                        {{ $s->year }}</span>
                                @endif
                                @if ($s->score)
                                    <span
                                        class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">🏅
                                        {{ $s->score }}</span>
                                @endif
                            </div>

                            <p class="mt-4 text-sm text-slate-600 leading-relaxed line-clamp-4">
                                “{{ $s->story }}”
                            </p>

                            <div class="mt-5 flex items-center justify-between">
                                <div class="text-xs text-slate-500">
                                    Updated: {{ $s->updated_at?->format('d M, Y') }}
                                </div>

                                <a href="{{ route('student.success_stories.edit', $s) }}"
                                    class="px-4 py-2 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50">
                                    Edit
                                </a>
                            </div>

                            @if (!$s->is_active)
                                <div
                                    class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                    This story is waiting for admin approval.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $stories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
