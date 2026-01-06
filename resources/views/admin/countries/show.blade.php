@extends('admin.layouts.app')

@section('page_title', 'Country Details')
@section('breadcrumb', 'Admin / Countries / Details')

@section('content')

    <div class="flex flex-col lg:flex-row lg:items-start gap-6">
        <div class="w-full lg:w-1/3">
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-center gap-3">
                    <div
                        class="h-12 w-12 rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                        @if ($country->flag_path)
                            <img class="h-12 w-12 object-cover" src="{{ asset('storage/' . $country->flag_path) }}"
                                alt="">
                        @else
                            <span class="text-[10px] text-slate-500">No Flag</span>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <div class="text-lg font-semibold truncate">{{ $country->name }}</div>
                        <div class="text-xs text-slate-500 truncate">{{ $country->slug }}</div>
                    </div>
                </div>

                <div class="p-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">ISO</span>
                        <span class="font-medium text-slate-800">{{ $country->iso2 ?? '—' }} /
                            {{ $country->iso3 ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Currency</span>
                        <span class="font-medium text-slate-800">{{ $country->currency ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Phone code</span>
                        <span class="font-medium text-slate-800">{{ $country->phone_code ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Sort order</span>
                        <span class="font-medium text-slate-800">{{ $country->sort_order }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Status</span>
                        @if ($country->is_active)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Active
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-50 text-amber-700 border border-amber-200">
                                Inactive
                            </span>
                        @endif
                    </div>

                    @if ($country->description)
                        <div class="pt-2 border-t border-slate-200">
                            <div class="text-xs text-slate-500 mb-1">Description</div>
                            <div class="text-slate-700 leading-relaxed">
                                {{ $country->description }}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-5 border-t border-slate-200 flex items-center gap-2">
                    <a href="{{ route('countries.edit', $country) }}"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Edit
                    </a>
                    <a href="{{ route('countries.index') }}"
                        class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Back to list
                    </a>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="text-xs text-slate-500">Total States</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($statesCount) }}</div>
                    <div class="text-xs text-slate-500 mt-1">Under this country</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="text-xs text-slate-500">Total Cities</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($citiesCount) }}</div>
                    <div class="text-xs text-slate-500 mt-1">Cities under those states</div>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                    <div class="text-xs text-slate-500">Total Universities</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($universitiesCount) }}</div>
                    <div class="text-xs text-slate-500 mt-1">In this country</div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-slate-500">Preview</div>
                        <div class="text-lg font-semibold">Top States</div>
                    </div>
                    <div class="text-xs text-slate-500">Up to 10</div>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($topStates as $st)
                        <div class="p-5 flex items-center justify-between">
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-800 truncate">{{ $st->name }}</div>
                                <div class="text-xs text-slate-500">Status: {{ $st->is_active ? 'Active' : 'Inactive' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-slate-500">Cities</div>
                                <div class="text-xl font-bold">{{ number_format($st->cities_count ?? 0) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500">No states found for this country.</div>
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
                        <div class="border border-slate-200 rounded-2xl p-4 hover:bg-slate-50/60 transition">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-10 w-10 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                                    @if ($u->logo_path)
                                        <img class="h-10 w-10 object-cover" src="{{ asset('storage/' . $u->logo_path) }}"
                                            alt="">
                                    @else
                                        <span class="text-[10px] text-slate-500">Logo</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-800 truncate">{{ $u->name }}</div>
                                    <div class="text-xs text-slate-500 truncate">{{ $u->slug }}</div>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center gap-2">
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
                        <div class="col-span-2 p-8 text-center text-slate-500">No universities found for this country.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
