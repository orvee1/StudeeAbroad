@props(['size' => 'h-10 w-10', 'imageClass' => 'object-contain', 'wrapperClass' => 'rounded-2xl bg-white ring-1 ring-black/5'])

<span {{ $attributes->merge(['class' => "flex {$size} shrink-0 items-center justify-center overflow-hidden {$wrapperClass}"]) }}>
    <img src="{{ asset('images/exfreelance-logo-cropped.jpeg') }}" alt="{{ config('app.name', 'EXFREELANCE') }} logo" class="h-full w-full {{ $imageClass }}">
</span>
