@extends('admin.layouts.app')

@section('page_title', 'Homepage Slider')
@section('breadcrumb', 'Admin / Website content / Homepage slider')

@section('content')
    @if (session('success'))
        <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col justify-between gap-4 border-b border-slate-200 p-5 sm:flex-row sm:items-center sm:p-6">
            <div>
                <p class="text-xs font-bold uppercase tracking-[.16em] text-emerald-700">Website content</p>
                <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-950">Homepage image slider</h2>
                <p class="mt-1 text-sm text-slate-600">Up to 8 active slides rotate every 5 seconds. Lower sort numbers appear first.</p>
            </div>
            <a href="{{ route('home_slides.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">
                <span aria-hidden="true" class="text-lg leading-none">+</span> Add slide
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Slide</th>
                        <th class="px-5 py-3">Overlay text</th>
                        <th class="px-5 py-3">Order</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($slides as $slide)
                        <tr class="align-middle transition hover:bg-slate-50/70">
                            <td class="w-64 px-5 py-4">
                                <img src="{{ asset('storage/' . ltrim($slide->image_path, '/')) }}" alt="{{ $slide->title }}" class="h-24 w-44 rounded-xl border border-slate-200 bg-slate-100 object-cover">
                            </td>
                            <td class="min-w-64 px-5 py-4">
                                <p class="font-bold text-slate-900">{{ $slide->title }}</p>
                                @if ($slide->subtitle)
                                    <p class="mt-1 line-clamp-2 max-w-xl text-xs leading-5 text-slate-500">{{ $slide->subtitle }}</p>
                                @endif
                                @if ($slide->button_text)
                                    <p class="mt-2 text-xs font-semibold text-blue-700">CTA: {{ $slide->button_text }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-700">{{ $slide->sort_order }}</td>
                            <td class="px-5 py-4">
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset',
                                    'bg-emerald-50 text-emerald-800 ring-emerald-200' => $slide->is_active,
                                    'bg-slate-100 text-slate-600 ring-slate-200' => ! $slide->is_active,
                                ])>{{ $slide->is_active ? 'Active' : 'Hidden' }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('home_slides.edit', $slide) }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">Edit</a>
                                    <form method="POST" action="{{ route('home_slides.destroy', $slide) }}" onsubmit="return confirm('Delete this homepage slide?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 transition hover:bg-rose-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-2">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-700" aria-hidden="true">▧</div>
                                <p class="mt-4 font-bold text-slate-900">No homepage slides yet</p>
                                <p class="mt-1 text-sm text-slate-500">Upload a wide image and add the text visitors will see on it.</p>
                                <a href="{{ route('home_slides.create') }}" class="mt-4 inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-700">Create the first slide</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 p-4 sm:p-5">{{ $slides->links() }}</div>
    </div>
@endsection
