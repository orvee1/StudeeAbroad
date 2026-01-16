@extends('admin.layouts.app')

@section('page_title', 'State Details')
@section('breadcrumb', 'Admin / States / Details')

@section('content')

    <div class="flex flex-col lg:flex-row lg:items-start gap-6">
        <div class="w-full lg:w-1/3">
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200">
                    <div class="text-xs text-slate-500">Country</div>
                    <div class="text-lg font-semibold">{{ $state->country?->name ?? '—' }}</div>
                </div>

                <div class="p-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">State</span>
                        <span class="font-medium text-slate-800">{{ $state->name }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Slug</span>
                        <span class="font-medium text-slate-800">{{ $state->slug }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Code</span>
                        <span class="font-medium text-slate-800">{{ $state->code ?? '—' }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Sort</span>
                        <span class="font-medium text-slate-800">{{ $state->sort_order }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Status</span>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                        {{ $state->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                            {{ $state->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    @if ($state->description)
                        <div class="pt-2 border-t border-slate-200">
                            <div class="text-xs text-slate-500 mb-1">Description</div>
                            <div class="text-slate-700 leading-relaxed">{{ $state->description }}</div>
                        </div>
                    @endif
                </div>

                <div class="p-5 border-t border-slate-200 flex items-center gap-2">
                    <a href="{{ route('admin.states.edit', $state) }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Edit
                    </a>
                    <a href="{{ route('admin.states.index') }}"
                        class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="text-xs text-slate-500">Total Cities</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($citiesCount) }}</div>
                    <div class="text-xs text-slate-500 mt-1">Under this state</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="text-xs text-slate-500">Total Universities</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($universitiesCount) }}</div>
                    <div class="text-xs text-slate-500 mt-1">In this state</div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-slate-500">Preview</div>
                        <div class="text-lg font-semibold">Cities</div>
                    </div>
                    <div class="text-xs text-slate-500">Up to 12</div>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($topCities as $c)
                        <div class="border border-slate-200 rounded-2xl p-4">
                            <div class="font-semibold">{{ $c->name }}</div>
                            <div class="text-xs text-slate-500">{{ $c->slug }}</div>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                {{ $c->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $c->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 p-8 text-center text-slate-500">No cities found.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-slate-500">Preview</div>
                        <div class="text-lg font-semibold">Latest Universities</div>
                    </div>
                    <div class="text-xs text-slate-500">Up to 8</div>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($latestUniversities as $u)
                        <div class="border border-slate-200 rounded-2xl p-4">
                            <div class="font-semibold">{{ $u->name }}</div>
                            <div class="text-xs text-slate-500">{{ $u->slug }}</div>
                            <div class="mt-2 flex items-center gap-2">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs border
                                {{ $u->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ $u->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($u->is_featured)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-900 text-white">
                                        Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 p-8 text-center text-slate-500">No universities found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
