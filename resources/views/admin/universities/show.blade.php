@extends('admin.layouts.app')

@section('page_title', 'University Details')
@section('breadcrumb', 'Admin / Universities / Details')

<div class="mb-4 bg-white border border-slate-200 rounded-2xl p-3 flex flex-wrap gap-2">
    <a href="{{ route('universities.show', $university) }}"
       class="px-4 py-2 rounded-xl text-sm border border-slate-200 bg-slate-900 text-white">
        Overview
    </a>
    <a href="{{ route('universities.programs.index', $university) }}"
       class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">
        Programs
    </a>
    <a href="{{ route('universities.media.index', $university) }}"
       class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">
        Media
    </a>
</div>

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-center gap-3">
                    <div
                        class="h-12 w-12 rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                        @if ($university->logo_path)
                            <img class="h-12 w-12 object-cover" src="{{ asset('storage/' . $university->logo_path) }}"
                                alt="">
                        @else
                            <span class="text-[10px] text-slate-500">Logo</span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="text-lg font-semibold truncate">{{ $university->name }}</div>
                        <div class="text-xs text-slate-500 truncate">{{ $university->slug }}</div>
                    </div>
                </div>

                <div class="p-5 text-sm space-y-3">
                    <div class="flex justify-between"><span class="text-slate-500">Country</span><span
                            class="font-medium">{{ $university->country?->name ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">State</span><span
                            class="font-medium">{{ $university->state?->name ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">City</span><span
                            class="font-medium">{{ $university->city?->name ?? '—' }}</span></div>

                    <div class="flex justify-between"><span class="text-slate-500">Type</span><span
                            class="font-medium">{{ $university->type ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Established</span><span
                            class="font-medium">{{ $university->established_year ?? '—' }}</span></div>

                    <div class="flex justify-between"><span class="text-slate-500">Ranking</span><span
                            class="font-medium">{{ $university->world_ranking ? '#' . $university->world_ranking : '—' }}</span>
                    </div>
                    <div class="flex justify-between"><span class="text-slate-500">Acceptance</span><span
                            class="font-medium">{{ $university->acceptance_rate !== null ? $university->acceptance_rate . '%' : '—' }}</span>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                        {{ $university->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                            {{ $university->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if ($university->is_featured)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-900 text-white">Featured</span>
                        @endif
                        @if ($university->scholarship_available)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs border border-slate-200">Scholarship</span>
                        @endif
                    </div>

                    @if ($university->address)
                        <div class="pt-3 border-t border-slate-200">
                            <div class="text-xs text-slate-500 mb-1">Address</div>
                            <div class="text-slate-700">{{ $university->address }}</div>
                        </div>
                    @endif
                </div>

                <div class="p-5 border-t border-slate-200 flex items-center gap-2">
                    <a href="{{ route('universities.edit', $university) }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Edit</a>
                    <a href="{{ route('universities.index') }}"
                        class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Back</a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @if ($university->cover_path)
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                    <img src="{{ asset('storage/' . $university->cover_path) }}" class="w-full h-56 object-cover"
                        alt="">
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <div class="text-lg font-semibold">Costs</div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <div class="text-xs text-slate-500">Tuition (year)</div>
                        <div class="text-xl font-bold mt-1">
                            {{ $university->tuition_min !== null ? number_format($university->tuition_min) : '—' }}
                            -
                            {{ $university->tuition_max !== null ? number_format($university->tuition_max) : '—' }}
                        </div>
                    </div>
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <div class="text-xs text-slate-500">Living cost (year)</div>
                        <div class="text-xl font-bold mt-1">
                            {{ $university->living_cost_min !== null ? number_format($university->living_cost_min) : '—' }}
                            -
                            {{ $university->living_cost_max !== null ? number_format($university->living_cost_max) : '—' }}
                        </div>
                    </div>
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <div class="text-xs text-slate-500">Application fee</div>
                        <div class="text-xl font-bold mt-1">
                            {{ $university->application_fee !== null ? number_format($university->application_fee) : '—' }}
                        </div>
                    </div>
                </div>
            </div>

            @if ($university->short_description || $university->description)
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="text-lg font-semibold">Description</div>
                    @if ($university->short_description)
                        <p class="mt-2 text-slate-700">{{ $university->short_description }}</p>
                    @endif
                    @if ($university->description)
                        <div class="mt-4 prose max-w-none">
                            {!! nl2br(e($university->description)) !!}
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-white border border-slate-200 rounded-2xl p-5">
                <div class="text-lg font-semibold">Contact</div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <div class="text-xs text-slate-500">Website</div>
                        <div class="font-semibold mt-1 break-all">{{ $university->website_url ?? '—' }}</div>
                    </div>
                    <div class="border border-slate-200 rounded-2xl p-4">
                        <div class="text-xs text-slate-500">Email / Phone</div>
                        <div class="font-semibold mt-1 break-all">{{ $university->email ?? '—' }}</div>
                        <div class="text-slate-600 break-all">{{ $university->phone ?? '' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
