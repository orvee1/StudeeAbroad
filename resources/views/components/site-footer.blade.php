<footer id="footer" class="border-t border-[#285b51] bg-[#143f38] text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[1.2fr_.8fr_.8fr] lg:px-8 lg:py-14">
        <div class="max-w-sm">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" />
                <span class="font-bold tracking-tight">{{ config('app.name', 'EXFREELANCE') }}</span>
            </a>
            <p class="mt-4 text-sm leading-6 text-[#c5d8ce]">Explore study destinations and find universities that fit your plans.</p>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#f0b08b]">Explore</h2>
            <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-[#e1ebe4]" aria-label="Footer navigation">
                <a href="{{ route('search') }}" class="transition hover:text-white">Find universities</a>
                <a href="{{ route('public.programs.index') }}" class="transition hover:text-white">Find programs</a>
                <a href="{{ route('home') }}#destinations" class="transition hover:text-white">Study destinations</a>
                <a href="{{ route('home') }}#universities" class="transition hover:text-white">Featured universities</a>
            </nav>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#f0b08b]">Your journey</h2>
            <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-[#e1ebe4]" aria-label="Journey links">
                <a href="{{ route('home') }}#how-it-works" class="transition hover:text-white">How it works</a>
                <a href="{{ route('home') }}#stories" class="transition hover:text-white">Student stories</a>
                <a href="#top" class="transition hover:text-white">Back to top ↑</a>
            </nav>
        </div>
    </div>
    <div class="border-t border-white/15">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-[#c5d8ce] sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p>
            <p>Find your place to study.</p>
        </div>
    </div>
</footer>
