@extends('student.layouts.app')

@section('page_title', 'Student Dashboard')

@section('content')
    @php
        $quickStats = $quickStats ?? ['countries' => 0, 'universities' => 0, 'featured_universities' => 0];
        $topCountries = $topCountries ?? collect();
        $featuredUniversities = $featuredUniversities ?? collect();
    @endphp

    <div class="space-y-8">

        {{-- Hero --}}
        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
            <div class="p-6 lg:p-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="max-w-2xl">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs border border-slate-200 bg-slate-50 text-slate-600">
                            ✨ Welcome, {{ auth()->user()->name }}
                        </div>

                        <h1 class="mt-4 text-2xl lg:text-4xl font-bold text-slate-900 leading-tight">
                            Find the right university, the right city, and your next big opportunity.
                        </h1>

                        <p class="mt-3 text-slate-600">
                            Explore featured universities, compare costs, and shortlist the best options for your study
                            abroad journey.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="#featured-universities"
                                class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                                Explore Featured Universities
                            </a>
                            <a href="#top-countries"
                                class="px-5 py-3 rounded-2xl border border-slate-200 text-sm hover:bg-slate-50">
                                Browse Top Countries
                            </a>
                        </div>

                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="border border-slate-200 rounded-2xl p-4">
                                <div class="text-xs text-slate-500">Active Countries</div>
                                <div class="text-2xl font-bold mt-1">{{ number_format($quickStats['countries'] ?? 0) }}
                                </div>
                            </div>
                            <div class="border border-slate-200 rounded-2xl p-4">
                                <div class="text-xs text-slate-500">Active Universities</div>
                                <div class="text-2xl font-bold mt-1">{{ number_format($quickStats['universities'] ?? 0) }}
                                </div>
                            </div>
                            <div class="border border-slate-200 rounded-2xl p-4">
                                <div class="text-xs text-slate-500">Featured Picks</div>
                                <div class="text-2xl font-bold mt-1">
                                    {{ number_format($quickStats['featured_universities'] ?? 0) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-[420px] space-y-4">
                        {{-- Quick Tips --}}
                        <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-6">
                            <div class="text-sm font-semibold text-slate-900">Quick Tips</div>
                            <ul class="mt-3 space-y-3 text-sm text-slate-600">
                                <li class="flex gap-2">
                                    <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                                    Compare tuition + living costs before shortlisting.
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                                    Check acceptance rate and ranking if available.
                                </li>
                                <li class="flex gap-2">
                                    <span class="mt-1 h-2 w-2 rounded-full bg-slate-900"></span>
                                    Look at programs & intakes that match your timeline.
                                </li>
                            </ul>

                            <div class="mt-5 border-t border-slate-200 pt-4">
                                <div class="text-xs text-slate-500">Next features you may want</div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">Wishlist</span>
                                    <span class="px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">Apply /
                                        Inquiry</span>
                                    <span class="px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">Cost
                                        Calculator</span>
                                </div>
                            </div>
                        </div>

                        {{-- Success Story CTA (New) --}}
                        <div class="rounded-3xl border border-slate-200 bg-white p-6">
                            <div class="text-sm text-slate-500">Inspire others</div>
                            <div class="text-lg font-semibold text-slate-900 mt-1">Share your success story</div>
                            <p class="text-sm text-slate-600 mt-2">
                                If you received an offer/visa, submit your story. After admin approval, it will appear on
                                the home page.
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('student.success_stories.create') }}"
                                    class="px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                                    Submit Story
                                </a>
                                <a href="{{ route('student.success_stories.index') }}"
                                    class="px-4 py-2.5 rounded-2xl border border-slate-200 text-sm hover:bg-slate-50">
                                    My Stories
                                </a>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                Tip: Keep it short, clear, and honest—no sensitive info.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Optional: Search universities (direct to public search) --}}
        <div class="bg-white border border-slate-200 rounded-3xl p-6">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Quick Search</div>
                    <div class="text-xl font-semibold text-slate-900">Find universities fast</div>
                </div>
                <a href="{{ route('search') }}"
                    class="text-sm px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50">
                    Advanced Search
                </a>
            </div>

            <form class="mt-5 grid grid-cols-1 md:grid-cols-4 gap-3" method="GET" action="{{ route('search') }}">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Keyword</label>
                    <input name="q" placeholder="University name, program, city..."
                        class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                </div>

                <div>
                    <label class="text-xs text-slate-500">Tuition Min</label>
                    <input type="number" name="tuition_min" placeholder="0"
                        class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Search
                    </button>
                </div>
            </form>
        </div>

        {{-- Top Countries --}}
        <div id="top-countries" class="space-y-4">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Browse</div>
                    <div class="text-xl font-semibold text-slate-900">Top Countries</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($topCountries as $c)
                    <div class="bg-white border border-slate-200 rounded-3xl p-5 hover:bg-slate-50/60 transition">
                        <div class="flex items-center gap-3">
                            <div
                                class="h-12 w-12 rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                                @if ($c->flag_path)
                                    <img class="h-12 w-12 object-cover" src="{{ asset('storage/' . $c->flag_path) }}"
                                        alt="">
                                @else
                                    <span class="text-[10px] text-slate-500">FLAG</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-900 truncate">{{ $c->name }}</div>
                                <div class="text-xs text-slate-500 truncate">{{ $c->slug ?? '' }}</div>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-slate-600">
                            Popular universities, cities and programs.
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('search', ['country_id' => $c->id]) }}"
                                class="inline-flex px-4 py-2 rounded-2xl border border-slate-200 text-sm hover:bg-white">
                                Explore
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 bg-white border border-slate-200 rounded-3xl p-10 text-center text-slate-500">
                        No countries found.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Featured Universities --}}
        <div id="featured-universities" class="space-y-4">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Recommended</div>
                    <div class="text-xl font-semibold text-slate-900">Featured Universities</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($featuredUniversities as $u)
                    <div
                        class="bg-white border border-slate-200 rounded-3xl overflow-hidden hover:bg-slate-50/60 transition">
                        <div class="p-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-12 w-12 rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center border border-slate-200">
                                    @if ($u->logo_path)
                                        <img class="h-12 w-12 object-cover" src="{{ asset('storage/' . $u->logo_path) }}"
                                            alt="">
                                    @else
                                        <span class="text-[10px] text-slate-500">LOGO</span>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">{{ $u->name }}</div>
                                    <div class="text-xs text-slate-500 truncate">
                                        {{ $u->city?->name ?? '—' }}, {{ $u->state?->name ?? '—' }}
                                    </div>
                                    <div class="text-xs text-slate-500 truncate">
                                        {{ $u->country?->name ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                                <div class="border border-slate-200 rounded-2xl p-3">
                                    <div class="text-xs text-slate-500">Tuition</div>
                                    <div class="font-semibold text-slate-900 mt-1">
                                        @if ($u->tuition_min !== null || $u->tuition_max !== null)
                                            {{ $u->tuition_min !== null ? number_format($u->tuition_min) : '—' }}
                                            -
                                            {{ $u->tuition_max !== null ? number_format($u->tuition_max) : '—' }}
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                                <div class="border border-slate-200 rounded-2xl p-3">
                                    <div class="text-xs text-slate-500">Living</div>
                                    <div class="font-semibold text-slate-900 mt-1">
                                        @if ($u->living_cost_min !== null || $u->living_cost_max !== null)
                                            {{ $u->living_cost_min !== null ? number_format($u->living_cost_min) : '—' }}
                                            -
                                            {{ $u->living_cost_max !== null ? number_format($u->living_cost_max) : '—' }}
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @if ($u->scholarship_available)
                                    <span
                                        class="px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">Scholarship</span>
                                @endif
                                @if ($u->world_ranking)
                                    <span class="px-3 py-1 rounded-full text-xs bg-slate-900 text-white">Rank
                                        #{{ $u->world_ranking }}</span>
                                @endif
                                @if ($u->acceptance_rate !== null)
                                    <span class="px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">
                                        {{ $u->acceptance_rate }}% acceptance
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5">
                                <a href="{{ route('search', ['q' => $u->name]) }}"
                                    class="w-full inline-flex justify-center px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                                    View (Next)
                                </a>
                                <div class="text-xs text-slate-500 mt-2 text-center">
                                    Public university page can be linked later.
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 bg-white border border-slate-200 rounded-3xl p-10 text-center text-slate-500">
                        No featured universities found.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- CTA --}}
        <div class="bg-slate-900 text-white rounded-3xl overflow-hidden">
            <div class="p-6 lg:p-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-2xl">
                    <div class="text-sm text-slate-200">Ready to shortlist?</div>
                    <div class="text-2xl lg:text-3xl font-bold mt-2">
                        Save your favorite universities and apply with confidence.
                    </div>
                    <p class="text-slate-200 mt-2">
                        Next we can add Wishlist + Inquiry/Apply form so you can contact the team with one click.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button"
                        class="px-5 py-3 rounded-2xl bg-white text-slate-900 text-sm font-semibold hover:opacity-95">
                        Add Wishlist (Next)
                    </button>
                    <button type="button" class="px-5 py-3 rounded-2xl border border-white/25 text-sm hover:bg-white/10">
                        Inquiry Form (Next)
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
