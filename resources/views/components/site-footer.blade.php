<footer id="footer" class="brand-footer">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[1.2fr_.8fr_.8fr] lg:px-8 lg:py-14">
        <div class="max-w-sm">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-16 w-64" wrapper-class="rounded-lg ring-0 bg-transparent" />
                <span class="font-bold tracking-tight">{{ config('app.name', 'EXFREELANCE') }}</span>
            </a>
            <p class="mt-4 text-sm leading-6 text-white/75">Explore study destinations and find universities that fit your plans.</p>
            <a href="https://wa.me/8801965999950" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp at +880 1965-999950" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-[#4ac782]/45 bg-[#20b763]/20 px-3.5 py-2.5 text-sm font-bold text-white transition hover:bg-[#20b763]/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#4ac782] focus-visible:ring-offset-2 focus-visible:ring-offset-[#102d48]"><span class="text-[#69db97]" aria-hidden="true">WhatsApp</span><span>+880 1965-999950</span></a>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffc15e]">Explore</h2>
            <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-white/80" aria-label="Footer navigation">
                <a href="{{ route('search') }}" class="transition hover:text-white">Find universities</a>
                <a href="{{ route('public.programs.index') }}" class="transition hover:text-white">Find programs</a>
                <a href="{{ route('home') }}#destinations" class="transition hover:text-white">Study destinations</a>
                <a href="{{ route('home') }}#universities" class="transition hover:text-white">Featured universities</a>
            </nav>
        </div>
        <div>
            <h2 class="text-xs font-bold uppercase tracking-[.16em] text-[#ffc15e]">Your journey</h2>
            <nav class="mt-4 flex flex-col items-start gap-3 text-sm text-white/80" aria-label="Journey links">
                <a href="{{ route('home') }}#how-it-works" class="transition hover:text-white">How it works</a>
                <a href="{{ route('home') }}#stories" class="transition hover:text-white">Student stories</a>
                <a href="#top" class="transition hover:text-white">Back to top ↑</a>
            </nav>
        </div>
    </div>
    <div class="border-t border-white/15">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-white/65 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} {{ config('app.name', 'EXFREELANCE') }}. All rights reserved.</p>
            <p>Find your place to study.</p>
        </div>
    </div>
</footer>
