<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Read {{ $story->name }}’s study abroad story.">
    <title>{{ $story->name }}’s story — {{ config('app.name', 'EXFREELANCE') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="brand-theme min-h-screen bg-[#fffaf5] font-sans text-[#133f39] antialiased">
    <header class="border-b border-[#ebe4d9] bg-white/90">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-12 w-48" wrapper-class="rounded-lg ring-0 bg-transparent" />
            </a>
            <a href="{{ route('home') }}#stories" class="text-sm font-semibold text-[#0757a6] hover:text-[#142b4a]">All student stories</a>
        </div>
    </header>

    @php($storyPhoto = $story->photo_path ?: ($story->user?->role === 'student' ? $story->user?->profile_photo_path : null))

    <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
        <article class="overflow-hidden rounded-[2rem] border border-[#dce8f1] bg-white shadow-xl shadow-[#142b4a]/10">
            <div class="bg-gradient-to-br from-[#eaf7ff] via-white to-[#fff3e4] p-6 sm:p-10">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-3xl bg-[#e7f3ea] text-2xl font-bold text-[#2b776b]">
                        @if($storyPhoto)<img src="{{ asset('storage/' . ltrim($storyPhoto, '/')) }}" alt="Photo of {{ $story->name }}" class="h-full w-full object-cover">@else{{ mb_substr($story->name, 0, 1) }}@endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96545]">Student success story</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-[#142b4a] sm:text-4xl">{{ $story->name }}</h1>
                        @if($story->from)<p class="mt-1 text-sm text-[#58718a]">{{ $story->from }}</p>@endif
                        @if($story->badge)<span class="mt-3 inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-[#0757a6] ring-1 ring-inset ring-[#cfe1ec]">{{ $story->badge }}</span>@endif
                    </div>
                </div>

                @if($story->destination || $story->year || $story->score)
                    <dl class="mt-7 grid gap-4 border-t border-[#dce8f1] pt-5 sm:grid-cols-3">
                        @if($story->destination)<div><dt class="text-xs font-semibold uppercase tracking-wide text-[#819087]">Study destination</dt><dd class="mt-1 text-sm font-semibold text-[#345c50]">{{ $story->destination }}</dd></div>@endif
                        @if($story->year)<div><dt class="text-xs font-semibold uppercase tracking-wide text-[#819087]">Year</dt><dd class="mt-1 text-sm font-semibold text-[#345c50]">{{ $story->year }}</dd></div>@endif
                        @if($story->score)<div><dt class="text-xs font-semibold uppercase tracking-wide text-[#819087]">English test or result</dt><dd class="mt-1 text-sm font-semibold text-[#345c50]">{{ $story->score }}</dd></div>@endif
                    </dl>
                @endif
            </div>

            <div class="grid gap-10 p-6 sm:p-10 lg:grid-cols-[.9fr_1.1fr]">
                <section aria-labelledby="student-story-heading">
                    <h2 id="student-story-heading" class="text-xl font-semibold text-[#142b4a]">The student’s story</h2>
                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-[#58718a]">{{ $story->story }}</p>
                </section>

                <section aria-labelledby="student-documents-heading">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96545]">Shared with permission</p>
                        <h2 id="student-documents-heading" class="mt-2 text-xl font-semibold text-[#142b4a]">Student documents</h2>
                        <p class="mt-2 text-sm leading-6 text-[#71879b]">The student has agreed to share these images as part of their story. Sensitive document details should be redacted.</p>
                    </div>

                    @if($story->media->isNotEmpty())
                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            @foreach($story->media as $media)
                                <figure class="overflow-hidden rounded-2xl border border-[#dce8f1] bg-[#f5f9fb]">
                                    <a href="{{ route('public.success_stories.media', [$story, $media]) }}" target="_blank" rel="noopener noreferrer" aria-label="Open {{ $media->type_label }} image in a new tab">
                                        <img src="{{ route('public.success_stories.media', [$story, $media]) }}" alt="Redacted {{ strtolower($media->type_label) }} image shared by {{ $story->name }}" loading="lazy" class="h-56 w-full object-contain p-2">
                                    </a>
                                    <figcaption class="border-t border-[#dce8f1] bg-white px-4 py-3 text-sm font-semibold text-[#345c50]">{{ $media->caption ?: $media->type_label }}</figcaption>
                                </figure>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-5 rounded-2xl border border-dashed border-[#d5ddd2] bg-[#f8faf6] px-4 py-8 text-center text-sm text-[#71817a]">No document images have been shared for this story.</p>
                    @endif
                </section>
            </div>
        </article>

        <div class="mt-7 text-center">
            <a href="{{ route('home') }}#stories" class="inline-flex items-center gap-2 rounded-xl bg-[#174f46] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#103e37]">Back to student stories</a>
        </div>
    </main>
</body>
</html>
