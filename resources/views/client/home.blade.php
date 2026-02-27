{{-- resources/views/client/home.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Studee Abroad') }} — Study Abroad Made Simple</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">

    @php
        // expected from controller:
        // $stats = ['countries'=>..., 'universities'=>..., 'programs'=>..., 'support'=>...]
        // $countries = Country::active() list for search dropdown
        // $topCountries = Country::withCount('universities') ... for top countries cards
        // $featuredUniversities = University::with(['country','state','city'])->withCount('programs') ... featured cards

        $stats = $stats ?? [
            'countries' => 0,
            'universities' => 0,
            'programs' => 0,
            'support' => '1:1',
        ];
    @endphp

    {{-- Top thin bar --}}
    <div class="border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-2 flex items-center justify-between text-sm">
            <div class="text-slate-600 flex items-center gap-2">
                <span
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-2 py-0.5 text-xs">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Guidance available
                </span>
                <span class="hidden sm:inline">Free guidance • Scholarship support • University shortlist</span>
                <span class="sm:hidden">Study Abroad Support</span>
            </div>

            <div class="flex items-center gap-2">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}"
                            class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:opacity-90 transition">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('student.dashboard') }}"
                            class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:opacity-90 transition">
                            My Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:opacity-90 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="h-10 w-10 rounded-2xl bg-slate-900"></div>
                <div>
                    <div class="text-sm font-semibold group-hover:opacity-90">{{ config('app.name', 'Studee Abroad') }}
                    </div>
                    <div class="text-xs text-slate-500">Study Abroad Platform</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm text-slate-700">
                <a href="#how-it-works" class="hover:text-slate-900 transition">How it works</a>
                <a href="#features" class="hover:text-slate-900 transition">Features</a>
                <a href="#countries" class="hover:text-slate-900 transition">Countries</a>
                <a href="#universities" class="hover:text-slate-900 transition">Universities</a>
                <a href="#testimonials" class="hover:text-slate-900 transition">Success</a>
                <a href="#contact" class="hover:text-slate-900 transition">Contact</a>
            </nav>

            <div class="flex items-center gap-2">
                <a href="#contact"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-sm transition">
                    Talk to us
                </a>

                @guest
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                        Start Free
                    </a>
                @endguest
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative">
        <div class="absolute inset-0 -z-10">
            <div class="absolute inset-x-0 top-0 h-[520px] bg-gradient-to-b from-indigo-50 via-white to-transparent">
            </div>
            <div class="absolute -top-24 -right-24 h-80 w-80 rounded-full bg-indigo-100 blur-3xl opacity-70"></div>
            <div class="absolute -bottom-28 -left-28 h-96 w-96 rounded-full bg-sky-100 blur-3xl opacity-70"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">
                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                        Trusted study abroad guidance
                    </div>

                    <h1 class="mt-5 text-3xl lg:text-5xl font-bold leading-tight text-slate-900">
                        Choose the right university with clarity — not confusion.
                    </h1>

                    <p class="mt-4 text-slate-600 text-lg">
                        Explore countries → states → cities → universities. Compare tuition, living cost, rankings and
                        programs.
                        Build a shortlist and move faster.
                    </p>

                    {{-- REAL Search (GET) --}}
                    <form action="{{ route('search') }}" method="GET"
                        class="mt-7 rounded-3xl border border-slate-200 bg-white p-3 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Country</label>
                                <select name="country_id" id="country_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                    @foreach ($countries ?? [] as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-slate-500">State</label>
                                <select name="state_id" id="state_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-slate-500">City</label>
                                <select name="city_id" id="city_id"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <option value="">Any</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-slate-500">Tuition Range</label>
                                <div class="mt-1 grid grid-cols-2 gap-2">
                                    <input type="number" name="tuition_min" placeholder="Min"
                                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                    <input type="number" name="tuition_max" placeholder="Max"
                                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                                </div>
                            </div>

                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                                    Search
                                </button>
                            </div>
                        </div>

                        <div class="mt-2 text-xs text-slate-500 px-1">
                            More filters (intake, level, keyword) are available on the results page.
                        </div>
                    </form>

                    <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <div class="text-xs text-slate-500">Countries</div>
                            <div class="text-xl font-bold mt-1 text-slate-900">
                                {{ number_format((int) ($stats['countries'] ?? 0)) }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <div class="text-xs text-slate-500">Universities</div>
                            <div class="text-xl font-bold mt-1 text-slate-900">
                                {{ number_format((int) ($stats['universities'] ?? 0)) }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <div class="text-xs text-slate-500">Programs</div>
                            <div class="text-xl font-bold mt-1 text-slate-900">
                                {{ number_format((int) ($stats['programs'] ?? 0)) }}</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <div class="text-xs text-slate-500">Support</div>
                            <div class="text-xl font-bold mt-1 text-slate-900">{{ $stats['support'] ?? '1:1' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Right info card --}}
                <div class="lg:pl-10">
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-200">
                            <div class="text-sm text-slate-500">What you get</div>
                            <div class="text-xl font-semibold mt-1 text-slate-900">A student-first experience</div>
                        </div>

                        <div class="p-6 space-y-3">
                            @foreach ([['i' => '✅', 't' => 'Smart Shortlist', 'd' => 'Save and compare universities quickly.'], ['i' => '💰', 't' => 'Cost Insights', 'd' => 'Tuition & living cost range in one place.'], ['i' => '🎯', 't' => 'Program Finder', 'd' => 'Filter by level, field, intake and more.'], ['i' => '🧾', 't' => 'Clear Steps', 'd' => 'A simple flow from research to applying.']] as $b)
                                <div class="flex gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <div
                                        class="h-10 w-10 rounded-2xl bg-white border border-slate-200 flex items-center justify-center">
                                        {{ $b['i'] }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $b['t'] }}</div>
                                        <div class="text-sm text-slate-600">{{ $b['d'] }}</div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="pt-2">
                                <a href="{{ route('register') }}"
                                    class="w-full inline-flex justify-center px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                                    Start Free — Create Account
                                </a>
                                <div class="text-xs text-slate-500 text-center mt-2">
                                    No payment required to register.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <div class="text-xs text-slate-500">Scholarship</div>
                            <div class="font-semibold mt-1 text-slate-900">Guidance</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <div class="text-xs text-slate-500">Visa</div>
                            <div class="font-semibold mt-1 text-slate-900">Checklist</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section id="how-it-works" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="text-center max-w-2xl mx-auto">
                <div class="text-sm text-slate-500">Simple steps</div>
                <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">How it works</h2>
                <p class="text-slate-600 mt-3">
                    A clean flow that matches your admin hierarchy: Country → State → City → University → Programs.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ([['n' => 'Step 1', 't' => 'Create your account', 'd' => 'Register in seconds and get your dashboard.'], ['n' => 'Step 2', 't' => 'Explore & shortlist', 'd' => 'Compare universities and programs easily.'], ['n' => 'Step 3', 't' => 'Apply with guidance', 'd' => 'Next: Inquiry/Apply workflow and tracking.']] as $s)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100/60 transition">
                        <div class="text-xs text-slate-500">{{ $s['n'] }}</div>
                        <div class="text-lg font-semibold mt-1 text-slate-900">{{ $s['t'] }}</div>
                        <div class="text-slate-600 mt-2 text-sm">{{ $s['d'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Designed for students</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">Features that make decisions easier
                    </h2>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                    Get started
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ([['t' => 'University Profiles', 'd' => 'Rankings, acceptance rate, tuition & living cost range.'], ['t' => 'Programs & Intakes', 'd' => 'Levels, fields, languages, intake months in one place.'], ['t' => 'Scholarship Tag', 'd' => 'Quickly spot scholarship-available universities.'], ['t' => 'Location Hierarchy', 'd' => 'Country → State → City filters (fast & organized).'], ['t' => 'Student Accounts', 'd' => 'Registration + dashboard built-in.'], ['t' => 'Admin Control', 'd' => 'Manage everything from a clean admin panel.']] as $f)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 hover:bg-slate-50 transition">
                        <div class="text-lg font-semibold text-slate-900">{{ $f['t'] }}</div>
                        <div class="text-slate-600 mt-2 text-sm">{{ $f['d'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Top Countries (DB) --}}
    <section id="countries" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Popular destinations</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">Top Countries</h2>
                    <p class="text-slate-600 mt-2 text-sm">Powered by your database (active countries + university
                        count).</p>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-sm transition">
                    Browse all (Next)
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse(($topCountries ?? []) as $c)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 hover:bg-slate-100/60 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="h-12 w-12 rounded-2xl bg-white border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    @if (!empty($c->flag_path))
                                        <img src="{{ asset('storage/' . $c->flag_path) }}"
                                            class="h-12 w-12 object-cover" alt="">
                                    @else
                                        <span class="text-[10px] text-slate-500">FLAG</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 text-lg truncate">{{ $c->name }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1 truncate">
                                        {{ $c->universities_count ?? 0 }} universities
                                    </div>
                                </div>
                            </div>

                            <span
                                class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-white text-slate-700 shrink-0">
                                Popular
                            </span>
                        </div>

                        <div class="mt-3 text-sm text-slate-600">
                            Explore universities, cities and programs.
                        </div>

                        <div class="mt-5 flex items-center gap-2">
                            <a href="{{ route('search', ['country_id' => $c->id]) }}"
                                class="px-4 py-2 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50 transition">
                                Explore
                            </a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                                Shortlist
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-600 col-span-4">
                        No countries found yet. Add countries from admin panel.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Featured Universities (DB) --}}
    <section id="universities" class="border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Hand-picked</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">Featured Universities</h2>
                    <p class="text-slate-600 mt-2 text-sm">Pulled from universities where featured + active.</p>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                    Start Free
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse(($featuredUniversities ?? []) as $u)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 hover:bg-slate-50 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-900 truncate">{{ $u->name }}</div>
                                <div class="text-sm text-slate-600 mt-1 truncate">
                                    {{ $u->city?->name ?? '—' }}, {{ $u->state?->name ?? '—' }}
                                </div>
                                <div class="text-xs text-slate-500 truncate">
                                    {{ $u->country?->name ?? '—' }}
                                </div>
                            </div>

                            <div
                                class="h-10 w-10 rounded-2xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                @if (!empty($u->logo_path))
                                    <img src="{{ asset('storage/' . $u->logo_path) }}" class="h-10 w-10 object-cover"
                                        alt="">
                                @else
                                    <span class="text-[10px] text-slate-500">LOGO</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @if ($u->scholarship_available)
                                <span
                                    class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">
                                    Scholarship
                                </span>
                            @endif
                            @if (!empty($u->world_ranking))
                                <span
                                    class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">
                                    Rank #{{ $u->world_ranking }}
                                </span>
                            @endif
                            <span
                                class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">
                                Programs: {{ $u->programs_count ?? 0 }}
                            </span>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs text-slate-500">Tuition</div>
                                <div class="font-semibold mt-1 text-slate-900">
                                    @if ($u->tuition_min !== null || $u->tuition_max !== null)
                                        {{ $u->tuition_min !== null ? number_format($u->tuition_min) : '—' }}
                                        -
                                        {{ $u->tuition_max !== null ? number_format($u->tuition_max) : '—' }}
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs text-slate-500">Living</div>
                                <div class="font-semibold mt-1 text-slate-900">
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

                        <a href="{{ route('search', ['q' => $u->name]) }}"
                            class="mt-5 w-full inline-flex justify-center px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                            View (Next)
                        </a>

                        <div class="mt-2 text-xs text-slate-500 text-center">
                            Public university page can be linked later.
                        </div>
                    </div>
                @empty
                    <div
                        class="rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-600 col-span-4">
                        No featured universities found. Mark some universities as featured from admin panel.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Testimonials / Success Stories --}}
    <section id="testimonials" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <div class="text-sm text-slate-500">Success stories</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">
                        Students who reached their dream universities
                    </h2>
                    <p class="text-slate-600 mt-2 text-sm max-w-2xl">
                        Real stories submitted by students (only approved ones are shown here).
                    </p>
                </div>

                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                    Start your journey
                </a>
            </div>

            @php
                $badgeStyle = function ($badge) {
                    return match ($badge) {
                        'Admitted' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Offer Received' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                        'Visa Approved' => 'bg-amber-50 text-amber-700 border-amber-200',
                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                };
            @endphp
            @php
                $successStories = $successStories ?? collect();
            @endphp
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($successStories as $t)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 hover:bg-slate-100/60 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="h-10 w-10 rounded-2xl bg-white border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    @if ($t->photo_path)
                                        <img src="{{ asset('storage/' . $t->photo_path) }}"
                                            class="h-10 w-10 object-cover" alt="">
                                    @else
                                        <span class="text-[10px] text-slate-500">Photo</span>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">{{ $t->name }}</div>
                                    <div class="text-xs text-slate-500 truncate">{{ $t->from ?? '—' }}</div>
                                </div>
                            </div>

                            @if ($t->badge)
                                <span
                                    class="shrink-0 text-[11px] px-2.5 py-1 rounded-full border {{ $badgeStyle($t->badge) }}">
                                    {{ $t->badge }}
                                </span>
                            @endif
                        </div>

                        @if ($t->destination)
                            <div class="mt-3 text-sm text-slate-700 font-medium">
                                {{ $t->destination }}
                            </div>
                        @endif

                        <p class="mt-3 text-sm text-slate-600 leading-relaxed line-clamp-5">
                            “{{ $t->story }}”
                        </p>

                        <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                            <div class="inline-flex items-center gap-2">
                                @if ($t->year)
                                    <span class="px-2 py-1 rounded-full border border-slate-200 bg-white">📅
                                        {{ $t->year }}</span>
                                @endif
                                @if ($t->score)
                                    <span class="px-2 py-1 rounded-full border border-slate-200 bg-white">🏅
                                        {{ $t->score }}</span>
                                @endif
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ $t->created_at?->format('d M, Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-4 rounded-3xl border border-dashed border-slate-200 bg-white p-10 text-center text-slate-600">
                        No approved success stories yet.
                    </div>
                @endforelse
            </div>

            <div
                class="mt-10 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between">
                <div>
                    <div class="text-sm text-slate-500">Want to share your story?</div>
                    <div class="text-lg font-semibold text-slate-900 mt-1">
                        Register and submit your success story.
                    </div>
                    <div class="text-sm text-slate-600 mt-1">
                        Admin approval is required before it appears publicly.
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('register') }}"
                        class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                        Create Free Account
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-5 py-3 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50 transition">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="text-sm text-slate-500">Need help choosing?</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">
                        Talk to our team and get a shortlist that fits your budget.
                    </h2>
                    <p class="text-slate-600 mt-3">
                        Next we can add Inquiry form + consultation workflow so students can submit their profile
                        directly.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="{{ route('register') }}"
                            class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                            Register Now
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-5 py-3 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50 transition">
                            Login
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <div class="text-sm font-semibold text-slate-900">Quick Contact (UI)</div>
                    <div class="text-sm text-slate-600 mt-1">Connect to backend later</div>

                    <div class="mt-4 space-y-3">
                        <input type="text" placeholder="Your name"
                            class="w-full rounded-2xl border-slate-200 bg-white placeholder:text-slate-400 focus:border-indigo-400 focus:ring-indigo-200" />
                        <input type="text" placeholder="Phone / WhatsApp"
                            class="w-full rounded-2xl border-slate-200 bg-white placeholder:text-slate-400 focus:border-indigo-400 focus:ring-indigo-200" />
                        <input type="email" placeholder="Email"
                            class="w-full rounded-2xl border-slate-200 bg-white placeholder:text-slate-400 focus:border-indigo-400 focus:ring-indigo-200" />
                        <textarea rows="4" placeholder="Your message..."
                            class="w-full rounded-2xl border-slate-200 bg-white placeholder:text-slate-400 focus:border-indigo-400 focus:ring-indigo-200"></textarea>

                        <button type="button"
                            class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                            Send (Coming Soon)
                        </button>
                    </div>
                </div>
            </div>

            <div
                class="mt-10 border-t border-slate-200 pt-6 text-sm text-slate-500 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
                <div>© {{ date('Y') }} {{ config('app.name', 'Studee Abroad') }}. All rights reserved.</div>
                <div class="flex gap-3">
                    <a class="hover:text-slate-900 transition" href="#">Privacy</a>
                    <a class="hover:text-slate-900 transition" href="#">Terms</a>
                    <a class="hover:text-slate-900 transition" href="#">Support</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Dependent dropdown JS (country -> states -> cities) --}}
    <script>
        (function() {
            const country = document.getElementById('country_id');
            const state = document.getElementById('state_id');
            const city = document.getElementById('city_id');

            async function loadStates(countryId) {
                if (!state) return;
                state.innerHTML = `<option value="">Any</option>`;
                city.innerHTML = `<option value="">Any</option>`;
                if (!countryId) return;

                const res = await fetch(`{{ route('api.states') }}?country_id=${countryId}`);
                const data = await res.json();
                data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.name;
                    state.appendChild(opt);
                });
            }

            async function loadCities(stateId) {
                if (!city) return;
                city.innerHTML = `<option value="">Any</option>`;
                if (!stateId) return;

                const res = await fetch(`{{ route('api.cities') }}?state_id=${stateId}`);
                const data = await res.json();
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name;
                    city.appendChild(opt);
                });
            }

            if (country) {
                country.addEventListener('change', e => loadStates(e.target.value));
            }
            if (state) {
                state.addEventListener('change', e => loadCities(e.target.value));
            }
        })();
    </script>

</body>

</html>
