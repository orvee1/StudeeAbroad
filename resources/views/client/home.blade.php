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

<body class="bg-white text-slate-900">
    {{-- Top Bar --}}
    <div class="border-b border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-2 flex items-center justify-between text-sm">
            <div class="text-slate-600">
                🎓 Free guidance • Scholarship support • University shortlist
            </div>

            <div class="flex items-center gap-3">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}"
                            class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:opacity-90">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('student.dashboard') }}"
                            class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:opacity-90">
                            My Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-white">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-3 py-1.5 rounded-xl bg-slate-900 text-white hover:opacity-90">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="h-10 w-10 rounded-2xl bg-slate-900"></div>
                <div>
                    <div class="text-sm font-semibold">{{ config('app.name', 'Studee Abroad') }}</div>
                    <div class="text-xs text-slate-500">Study Abroad Platform</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm text-slate-700">
                <a href="#how-it-works" class="hover:text-slate-900">How it works</a>
                <a href="#features" class="hover:text-slate-900">Features</a>
                <a href="#countries" class="hover:text-slate-900">Countries</a>
                <a href="#universities" class="hover:text-slate-900">Universities</a>
            </nav>

            <div class="flex items-center gap-2">
                <a href="#contact"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl border border-slate-200 text-sm hover:bg-slate-50">
                    Talk to us
                </a>

                @guest
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Start Free
                    </a>
                @endguest
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute -top-24 -right-24 h-80 w-80 rounded-full bg-slate-100"></div>
            <div class="absolute -bottom-28 -left-28 h-96 w-96 rounded-full bg-slate-50"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-14 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs border border-slate-200 bg-white">
                        🚀 Build your shortlist in minutes
                    </div>

                    <h1 class="mt-4 text-3xl lg:text-5xl font-bold leading-tight">
                        Find the best <span class="underline decoration-slate-300">University</span> for your Study
                        Abroad journey.
                    </h1>

                    <p class="mt-4 text-slate-600 text-lg">
                        Explore countries → states → cities → universities. Compare tuition, living cost, rankings and
                        programs.
                        Create a shortlist and move faster with guidance.
                    </p>

                    {{-- Quick “Search” (UI only for now) --}}
                    <div class="mt-6 bg-white border border-slate-200 rounded-3xl p-3">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs text-slate-500">Country</label>
                                <input type="text" placeholder="e.g. Canada"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500">City</label>
                                <input type="text" placeholder="e.g. Toronto"
                                    class="mt-1 w-full rounded-2xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                            </div>
                            <div class="flex items-end">
                                <button type="button"
                                    class="w-full px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                                    Search (Coming Soon)
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-slate-500 px-1">
                            Tip: We can connect this search to your public listing pages later.
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-2">
                        @guest
                            <a href="{{ route('register') }}"
                                class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                                Create Free Account
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-5 py-3 rounded-2xl border border-slate-200 text-sm hover:bg-slate-50">
                                I already have an account
                            </a>
                        @else
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}"
                                    class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                                    Go to Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('student.dashboard') }}"
                                    class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                                    Go to My Dashboard
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="border border-slate-200 rounded-2xl p-4 bg-white">
                            <div class="text-xs text-slate-500">Countries</div>
                            <div class="text-xl font-bold mt-1">50+</div>
                        </div>
                        <div class="border border-slate-200 rounded-2xl p-4 bg-white">
                            <div class="text-xs text-slate-500">Universities</div>
                            <div class="text-xl font-bold mt-1">500+</div>
                        </div>
                        <div class="border border-slate-200 rounded-2xl p-4 bg-white">
                            <div class="text-xs text-slate-500">Programs</div>
                            <div class="text-xl font-bold mt-1">2000+</div>
                        </div>
                        <div class="border border-slate-200 rounded-2xl p-4 bg-white">
                            <div class="text-xs text-slate-500">Support</div>
                            <div class="text-xl font-bold mt-1">1:1</div>
                        </div>
                    </div>
                </div>

                {{-- Right side card --}}
                <div class="lg:pl-10">
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
                        <div class="p-6 border-b border-slate-200">
                            <div class="text-sm text-slate-500">What you get</div>
                            <div class="text-xl font-semibold mt-1">A student-first experience</div>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="flex gap-3">
                                <div class="h-10 w-10 rounded-2xl bg-slate-100 flex items-center justify-center">✅</div>
                                <div>
                                    <div class="font-semibold">Smart Shortlist</div>
                                    <div class="text-sm text-slate-600">Save and compare universities fast.</div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="h-10 w-10 rounded-2xl bg-slate-100 flex items-center justify-center">💰
                                </div>
                                <div>
                                    <div class="font-semibold">Cost Insights</div>
                                    <div class="text-sm text-slate-600">Tuition & living cost range in one place.</div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="h-10 w-10 rounded-2xl bg-slate-100 flex items-center justify-center">🎯
                                </div>
                                <div>
                                    <div class="font-semibold">Program Finder</div>
                                    <div class="text-sm text-slate-600">Filter by level, field, intake and more.</div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <a href="{{ route('register') }}"
                                    class="w-full inline-flex justify-center px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                                    Start Free — Create Account
                                </a>
                                <div class="text-xs text-slate-500 text-center mt-2">
                                    No payment required to register.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50">
                            <div class="text-xs text-slate-500">Scholarship</div>
                            <div class="font-semibold mt-1">Guidance</div>
                        </div>
                        <div class="border border-slate-200 rounded-2xl p-4 bg-slate-50">
                            <div class="text-xs text-slate-500">Visa</div>
                            <div class="font-semibold mt-1">Checklist</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section id="how-it-works" class="border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="text-center max-w-2xl mx-auto">
                <div class="text-sm text-slate-500">Simple steps</div>
                <h2 class="text-2xl lg:text-3xl font-bold mt-2">How it works</h2>
                <p class="text-slate-600 mt-3">
                    A clean flow that matches your admin hierarchy: Country → State → City → University → Programs.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white border border-slate-200 rounded-3xl p-6">
                    <div class="text-xs text-slate-500">Step 1</div>
                    <div class="text-lg font-semibold mt-1">Create your account</div>
                    <div class="text-slate-600 mt-2 text-sm">Register in seconds and get your student dashboard.</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-6">
                    <div class="text-xs text-slate-500">Step 2</div>
                    <div class="text-lg font-semibold mt-1">Explore & shortlist</div>
                    <div class="text-slate-600 mt-2 text-sm">Browse universities and compare key info.</div>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-6">
                    <div class="text-xs text-slate-500">Step 3</div>
                    <div class="text-lg font-semibold mt-1">Apply with guidance</div>
                    <div class="text-slate-600 mt-2 text-sm">We can add Inquiry/Apply workflow next.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Designed for students</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2">Features that make decisions easier</h2>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                    Get started
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $featureCards = [
                        [
                            't' => 'University Profiles',
                            'd' => 'Rankings, acceptance rate, tuition & living cost range.',
                        ],
                        ['t' => 'Programs & Intakes', 'd' => 'Levels, fields, languages, intake months in one place.'],
                        ['t' => 'Scholarship Tag', 'd' => 'Quickly spot scholarship-available universities.'],
                        ['t' => 'Location Hierarchy', 'd' => 'Country → State → City filters (fast & organized).'],
                        ['t' => 'Student Accounts', 'd' => 'Registration + student dashboard built-in.'],
                        ['t' => 'Admin Control', 'd' => 'Manage everything from a clean admin panel.'],
                    ];
                @endphp

                @foreach ($featureCards as $f)
                    <div class="border border-slate-200 rounded-3xl p-6 hover:bg-slate-50/60 transition">
                        <div class="text-lg font-semibold">{{ $f['t'] }}</div>
                        <div class="text-slate-600 mt-2 text-sm">{{ $f['d'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Countries preview (static cards now) --}}
    <section id="countries" class="border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Popular destinations</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2">Top Countries</h2>
                    <p class="text-slate-600 mt-2 text-sm">We can connect these to real country pages when you want.
                    </p>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl border border-slate-200 hover:bg-white text-sm">
                    Browse all (Next)
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach (['Canada', 'USA', 'UK', 'Australia', 'Germany', 'Japan', 'Sweden', 'Malaysia'] as $c)
                    <div class="bg-white border border-slate-200 rounded-3xl p-5 hover:bg-slate-50/60 transition">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold">{{ $c }}</div>
                            <span class="text-xs px-2 py-1 rounded-full bg-slate-900 text-white">Hot</span>
                        </div>
                        <div class="text-sm text-slate-600 mt-2">
                            Explore universities, cities and programs.
                        </div>
                        <button type="button"
                            class="mt-4 px-4 py-2 rounded-2xl border border-slate-200 text-sm hover:bg-white">
                            Explore (Coming Soon)
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Universities preview (static) --}}
    <section id="universities" class="border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="flex items-end justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-500">Hand-picked</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2">Featured Universities</h2>
                    <p class="text-slate-600 mt-2 text-sm">Once your public pages are ready, these can be dynamic.</p>
                </div>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                    Start Free
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ([['n' => 'University of Toronto', 'l' => 'Toronto, Canada', 'tag' => 'Ranked'], ['n' => 'University of Melbourne', 'l' => 'Melbourne, Australia', 'tag' => 'Scholarship'], ['n' => 'LMU Munich', 'l' => 'Munich, Germany', 'tag' => 'Popular'], ['n' => 'University of Tokyo', 'l' => 'Tokyo, Japan', 'tag' => 'Top']] as $u)
                    <div class="border border-slate-200 rounded-3xl p-6 hover:bg-slate-50/60 transition">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold">{{ $u['n'] }}</div>
                            <span
                                class="text-xs px-2 py-1 rounded-full border border-slate-200 bg-white">{{ $u['tag'] }}</span>
                        </div>
                        <div class="text-sm text-slate-600 mt-2">{{ $u['l'] }}</div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div class="border border-slate-200 rounded-2xl p-3">
                                <div class="text-xs text-slate-500">Tuition</div>
                                <div class="font-semibold mt-1">—</div>
                            </div>
                            <div class="border border-slate-200 rounded-2xl p-3">
                                <div class="text-xs text-slate-500">Living</div>
                                <div class="font-semibold mt-1">—</div>
                            </div>
                        </div>

                        <button type="button"
                            class="mt-5 w-full px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90">
                            View (Coming Soon)
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact / CTA --}}
    <section id="contact" class="border-t border-slate-200 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="text-sm text-slate-200">Need help choosing?</div>
                    <h2 class="text-2xl lg:text-3xl font-bold mt-2">Talk to our team and get a shortlist that fits your
                        budget.</h2>
                    <p class="text-slate-200 mt-3">
                        We can add an Inquiry form + consultation workflow so students can submit their profile
                        directly.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="{{ route('register') }}"
                            class="px-5 py-3 rounded-2xl bg-white text-slate-900 text-sm font-semibold hover:opacity-95">
                            Register Now
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-5 py-3 rounded-2xl border border-white/20 text-sm hover:bg-white/10">
                            Login
                        </a>
                    </div>
                </div>

                <div class="bg-white/10 border border-white/15 rounded-3xl p-6">
                    <div class="text-sm font-semibold">Quick Contact (UI)</div>
                    <div class="text-sm text-slate-200 mt-1">Connect to backend later</div>

                    <div class="mt-4 space-y-3">
                        <input type="text" placeholder="Your name"
                            class="w-full rounded-2xl bg-white/10 border-white/15 placeholder:text-slate-300 focus:border-white/30 focus:ring-white/20" />
                        <input type="text" placeholder="Phone / WhatsApp"
                            class="w-full rounded-2xl bg-white/10 border-white/15 placeholder:text-slate-300 focus:border-white/30 focus:ring-white/20" />
                        <input type="email" placeholder="Email"
                            class="w-full rounded-2xl bg-white/10 border-white/15 placeholder:text-slate-300 focus:border-white/30 focus:ring-white/20" />
                        <textarea rows="4" placeholder="Your message..."
                            class="w-full rounded-2xl bg-white/10 border-white/15 placeholder:text-slate-300 focus:border-white/30 focus:ring-white/20"></textarea>

                        <button type="button"
                            class="w-full px-5 py-3 rounded-2xl bg-white text-slate-900 text-sm font-semibold hover:opacity-95">
                            Send (Coming Soon)
                        </button>
                    </div>
                </div>
            </div>

            <div
                class="mt-10 border-t border-white/10 pt-6 text-sm text-slate-300 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
                <div>© {{ date('Y') }} {{ config('app.name', 'Studee Abroad') }}. All rights reserved.</div>
                <div class="flex gap-3">
                    <a class="hover:text-white" href="#">Privacy</a>
                    <a class="hover:text-white" href="#">Terms</a>
                    <a class="hover:text-white" href="#">Support</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
