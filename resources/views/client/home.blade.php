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
        // Demo (static) data — later replace with DB
        $topCountries = [
            [
                'name' => 'Canada',
                'tag' => 'Best for PR',
                'desc' => 'Top universities • part-time work • strong job market',
            ],
            ['name' => 'USA', 'tag' => 'Top Rankings', 'desc' => 'World-class programs • research • scholarships'],
            ['name' => 'UK', 'tag' => '1-Year Masters', 'desc' => 'Shorter degree time • global recognition'],
            ['name' => 'Australia', 'tag' => 'Work + Study', 'desc' => 'Great student lifestyle • post-study work'],
            ['name' => 'Germany', 'tag' => 'Low Tuition', 'desc' => 'Affordable education • strong engineering'],
            ['name' => 'Japan', 'tag' => 'Innovation', 'desc' => 'Tech research • scholarships • unique culture'],
            ['name' => 'Sweden', 'tag' => 'Quality Living', 'desc' => 'Student-friendly cities • innovation'],
            ['name' => 'Malaysia', 'tag' => 'Affordable', 'desc' => 'Lower living cost • international campuses'],
        ];

        $featuredUniversities = [
            [
                'name' => 'University of Toronto',
                'location' => 'Toronto, Canada',
                'chips' => ['Ranked', 'Scholarship'],
                'tuition' => 'CAD 30k - 55k',
                'living' => 'CAD 12k - 20k',
            ],
            [
                'name' => 'University of Melbourne',
                'location' => 'Melbourne, Australia',
                'chips' => ['Popular', 'Work Options'],
                'tuition' => 'AUD 28k - 48k',
                'living' => 'AUD 15k - 24k',
            ],
            [
                'name' => 'LMU Munich',
                'location' => 'Munich, Germany',
                'chips' => ['Low Tuition', 'Research'],
                'tuition' => '€ 0 - 6k',
                'living' => '€ 10k - 16k',
            ],
            [
                'name' => 'University of Tokyo',
                'location' => 'Tokyo, Japan',
                'chips' => ['Top', 'Innovation'],
                'tuition' => '¥ 500k - 900k',
                'living' => '¥ 900k - 1.5M',
            ],
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

                    {{-- Search (UI only) --}}
                    <div class="mt-7 rounded-3xl border border-slate-200 bg-white p-3 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Country</label>
                                <input type="text" placeholder="e.g. Canada"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500">City</label>
                                <input type="text" placeholder="e.g. Toronto"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                            </div>
                            <div class="flex items-end">
                                <button type="button"
                                    class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                                    Search (Coming Soon)
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-slate-500 px-1">
                            Later we’ll connect this to public listing pages.
                        </div>
                    </div>

                    <div class="mt-7 flex flex-wrap gap-2">
                        @guest
                            <a href="{{ route('register') }}"
                                class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                                Create Free Account
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-5 py-3 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50 transition">
                                I already have an account
                            </a>
                        @else
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}"
                                    class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                                    Go to Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('student.dashboard') }}"
                                    class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                                    Go to My Dashboard
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ([['t' => 'Countries', 'v' => '50+'], ['t' => 'Universities', 'v' => '500+'], ['t' => 'Programs', 'v' => '2000+'], ['t' => 'Support', 'v' => '1:1']] as $s)
                            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                <div class="text-xs text-slate-500">{{ $s['t'] }}</div>
                                <div class="text-xl font-bold mt-1 text-slate-900">{{ $s['v'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right card --}}
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

    {{-- Countries --}}
    <section id="countries" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Popular destinations</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">Top Countries</h2>
                    <p class="text-slate-600 mt-2 text-sm">Demo data (static). Later we’ll load from database.</p>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-sm transition">
                    Browse all (Next)
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($topCountries as $c)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 hover:bg-slate-100/60 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-semibold text-slate-900 text-lg">{{ $c['name'] }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $c['tag'] }}</div>
                            </div>
                            <span
                                class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-white text-slate-700">
                                Popular
                            </span>
                        </div>

                        <div class="mt-3 text-sm text-slate-600">
                            {{ $c['desc'] }}
                        </div>

                        <div class="mt-5 flex items-center gap-2">
                            <button type="button"
                                class="px-4 py-2 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50 transition">
                                Explore (Coming Soon)
                            </button>
                            <button type="button"
                                class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                                Shortlist (Next)
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Universities --}}
    <section id="universities" class="border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Hand-picked</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2 text-slate-900">Featured Universities</h2>
                    <p class="text-slate-600 mt-2 text-sm">Demo data (static). Later we’ll load from database.</p>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                    Start Free
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($featuredUniversities as $u)
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 hover:bg-slate-50 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-900 truncate">{{ $u['name'] }}</div>
                                <div class="text-sm text-slate-600 mt-1 truncate">{{ $u['location'] }}</div>
                            </div>
                            <div class="h-10 w-10 rounded-2xl bg-slate-900"></div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($u['chips'] as $chip)
                                <span
                                    class="text-[11px] px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-700">
                                    {{ $chip }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs text-slate-500">Tuition</div>
                                <div class="font-semibold mt-1 text-slate-900">{{ $u['tuition'] }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                                <div class="text-xs text-slate-500">Living</div>
                                <div class="font-semibold mt-1 text-slate-900">{{ $u['living'] }}</div>
                            </div>
                        </div>

                        <button type="button"
                            class="mt-5 w-full px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-semibold text-sm hover:opacity-90 transition">
                            View Details (Coming Soon)
                        </button>

                        <div class="mt-2 text-xs text-slate-500 text-center">
                            Later this will open public university page.
                        </div>
                    </div>
                @endforeach
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
</body>

</html>
