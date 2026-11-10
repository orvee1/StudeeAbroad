@php($isEditing = $slide !== null)

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
    @csrf
    @if ($isEditing) @method('PUT') @endif

    <section class="grid gap-5 lg:grid-cols-[1.1fr_.9fr]" aria-label="Slide content">
        <div class="space-y-5">
            <div>
                <label for="slide-title" class="text-sm font-bold text-slate-800">Headline on image</label>
                <input id="slide-title" name="title" required maxlength="180" value="{{ old('title', $slide?->title) }}" placeholder="A world of study. A place for you." class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-slate-500">This is the main, large text visitors see.</p>
                @error('title')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="slide-subtitle" class="text-sm font-bold text-slate-800">Supporting text</label>
                <textarea id="slide-subtitle" name="subtitle" rows="4" maxlength="1000" placeholder="Add a short, helpful line that sits under the headline." class="mt-1.5 w-full rounded-xl border-slate-300 text-sm leading-6 focus:border-blue-500 focus:ring-blue-500">{{ old('subtitle', $slide?->subtitle) }}</textarea>
                <p class="mt-1 text-xs text-slate-500">Keep it short so it stays easy to read over the image.</p>
                @error('subtitle')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="slide-button-text" class="text-sm font-bold text-slate-800">Optional button label</label>
                    <input id="slide-button-text" name="button_text" maxlength="50" value="{{ old('button_text', $slide?->button_text) }}" placeholder="Explore destinations" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('button_text')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="slide-button-url" class="text-sm font-bold text-slate-800">Button URL</label>
                    <input id="slide-button-url" type="url" name="button_url" maxlength="255" value="{{ old('button_url', $slide?->button_url) }}" placeholder="https://example.com" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('button_url')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
            </div>
            <p class="-mt-3 text-xs text-slate-500">Leave both button fields blank if the slide should only show text.</p>
        </div>

        <div class="space-y-4">
            <div>
                <label for="slide-image" class="text-sm font-bold text-slate-800">Wide background image</label>
                <input id="slide-image" type="file" name="image" accept="image/jpeg,image/png,image/webp" @if (! $isEditing) required @endif class="mt-1.5 block w-full rounded-xl border border-slate-300 bg-white text-sm file:mr-4 file:rounded-l-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:font-bold file:text-blue-700">
                <p class="mt-1 text-xs leading-5 text-slate-500">JPG, PNG or WebP, up to 8 MB. A landscape image around 1920 × 800 works best.</p>
                @error('image')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>

            @if ($isEditing && $slide->image_path)
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                    <img src="{{ asset('storage/' . ltrim($slide->image_path, '/')) }}" alt="Current slide: {{ $slide->title }}" class="aspect-[16/8] w-full object-cover">
                    <p class="px-3 py-2 text-xs font-semibold text-slate-600">Current image</p>
                </div>
            @else
                <div class="flex min-h-36 items-center justify-center rounded-2xl border border-dashed border-blue-200 bg-blue-50/70 px-5 text-center text-sm leading-6 text-blue-800">
                    The image fills the hero area. A dark overlay will keep your headline readable.
                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="slide-sort-order" class="text-sm font-bold text-slate-800">Display order</label>
                    <input id="slide-sort-order" type="number" name="sort_order" min="0" step="1" value="{{ old('sort_order', $slide?->sort_order ?? 0) }}" class="mt-1.5 w-full rounded-xl border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('sort_order')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-end">
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex w-full items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">
                        <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $slide?->is_active ?? true)) class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                        Show on homepage
                    </label>
                </div>
            </div>
        </div>
    </section>

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('home_slides.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">Cancel</a>
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">{{ $isEditing ? 'Save slide' : 'Upload slide' }}</button>
    </div>
</form>
