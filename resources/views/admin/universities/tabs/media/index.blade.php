@extends('admin.layouts.app')

@section('page_title', 'Media')
@section('breadcrumb', 'Admin / Universities / Media')

@section('content')

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 bg-white border border-slate-200 rounded-2xl p-3 flex flex-wrap gap-2">
        <a href="{{ route('universities.show', $university) }}"
            class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">Overview</a>
        <a href="{{ route('universities.programs.index', $university) }}"
            class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">Programs</a>
        <a href="{{ route('universities.media.index', $university) }}"
            class="px-4 py-2 rounded-xl text-sm border border-slate-200 bg-slate-900 text-white">Media</a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
        <div class="p-4 lg:p-6 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <div>
                <div class="text-sm text-slate-500">University</div>
                <div class="text-xl font-semibold">{{ $university->name }}</div>
            </div>
            <a href="{{ route('universities.media.create', $university) }}"
                class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                + Upload Media
            </a>
        </div>

        <div class="p-4 lg:p-6 border-b border-slate-200">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-3" method="GET"
                action="{{ route('universities.media.index', $university) }}">
                <div>
                    <label class="text-xs text-slate-500">Type</label>
                    <select name="type"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                        <option value="">All</option>
                        <option value="image" @selected(($type ?? '') === 'image')>Image</option>
                        <option value="document" @selected(($type ?? '') === 'document')>Document</option>
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

                <div class="md:col-span-2 flex items-end gap-2">
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Filter</button>
                    <a href="{{ route('universities.media.index', $university) }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="p-4 lg:p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($media as $m)
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <div class="p-4 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="font-semibold truncate">{{ $m->title ?? 'Untitled' }}</div>
                            <div class="text-xs text-slate-500 truncate">{{ $m->type }} • {{ $m->mime_type ?? '—' }}
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                        {{ $m->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                            {{ $m->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="bg-slate-50 border-y border-slate-200">
                        @if ($m->type === 'image')
                            <img src="{{ asset('storage/' . $m->file_path) }}" class="w-full h-44 object-cover"
                                alt="">
                        @else
                            <div class="h-44 flex items-center justify-center text-slate-600 text-sm">
                                Document
                            </div>
                        @endif
                    </div>

                    <div class="p-4 text-sm">
                        @if ($m->caption)
                            <div class="text-slate-700">{{ $m->caption }}</div>
                        @else
                            <div class="text-slate-500">No caption</div>
                        @endif

                        <div class="mt-3 flex items-center justify-between">
                            <div class="text-xs text-slate-500">Sort: {{ $m->sort_order }}</div>
                            <div class="flex gap-2">
                                <a href="{{ route('universities.media.edit', [$university, $m]) }}"
                                    class="px-3 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Edit</a>
                                <form method="POST"
                                    action="{{ route('universities.media.destroy', [$university, $m]) }}"
                                    onsubmit="return confirm('Delete this media?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-2 rounded-xl border border-rose-200 text-rose-700 text-sm hover:bg-rose-50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-8 text-center text-slate-500">No media found.</div>
            @endforelse
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200">
            {{ $media->links() }}
        </div>
    </div>

@endsection
