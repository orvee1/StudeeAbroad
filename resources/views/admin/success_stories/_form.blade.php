@php($isEditing = $story !== null)

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
    @csrf
    @if ($isEditing) @method('PUT') @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="story-name" class="text-sm font-semibold text-slate-700">Student name</label>
            <input id="story-name" name="name" required maxlength="255" value="{{ old('name', $story->name ?? '') }}" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="story-from" class="text-sm font-semibold text-slate-700">Student location</label>
            <input id="story-from" name="from" maxlength="255" value="{{ old('from', $story->from ?? '') }}" placeholder="Dhaka, Bangladesh" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('from')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="story-destination" class="text-sm font-semibold text-slate-700">University and destination</label>
            <input id="story-destination" name="destination" maxlength="255" value="{{ old('destination', $story->destination ?? '') }}" placeholder="University of Toronto, Canada" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('destination')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="story-badge" class="text-sm font-semibold text-slate-700">Outcome badge</label>
            <input id="story-badge" name="badge" maxlength="50" value="{{ old('badge', $story->badge ?? '') }}" placeholder="Admitted, Offer Received, Visa Approved" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('badge')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="story-score" class="text-sm font-semibold text-slate-700">Test score (optional)</label>
            <input id="story-score" name="score" maxlength="50" value="{{ old('score', $story->score ?? '') }}" placeholder="IELTS 7.0" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('score')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="story-year" class="text-sm font-semibold text-slate-700">Year</label>
            <input id="story-year" name="year" maxlength="10" value="{{ old('year', $story->year ?? '') }}" placeholder="2026" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('year')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label for="story-text" class="text-sm font-semibold text-slate-700">Student story</label>
            <textarea id="story-text" name="story" required maxlength="20000" rows="5" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('story', $story->story ?? '') }}</textarea>
            @error('story')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label for="story-photo" class="text-sm font-semibold text-slate-700">Student photo (optional)</label>
            <input id="story-photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="mt-1.5 block w-full rounded-xl border border-slate-300 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold">
            <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP. Maximum 4 MB.</p>
            @error('photo')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
            @if ($isEditing && $story->photo_path)
                <img src="{{ asset('storage/' . ltrim($story->photo_path, '/')) }}" alt="Current photo of {{ $story->name }}" class="mt-3 h-20 w-20 rounded-xl object-cover">
            @endif
        </div>
    </div>

    <section class="space-y-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 sm:p-5" aria-labelledby="public-documents-heading">
        <div>
            <h2 id="public-documents-heading" class="font-bold text-amber-950">Student documents shown publicly</h2>
            <p class="mt-1 text-sm leading-6 text-amber-900">Upload redacted image copies only. Hide passport and visa numbers, date of birth, address, signatures, machine-readable zones, barcodes and QR codes, and remove image location metadata. Never upload an unredacted original.</p>
        </div>
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach (['passport_images' => 'Passport proof', 'visa_images' => 'Visa proof', 'admission_images' => 'University admission or offer letter'] as $field => $label)
                <div>
                    <label for="{{ $field }}" class="text-sm font-semibold text-amber-950">{{ $label }}</label>
                    <input id="{{ $field }}" type="file" name="{{ $field }}[]" accept="image/jpeg,image/png,image/webp" multiple class="mt-1.5 block w-full rounded-xl border border-amber-300 bg-white text-xs file:mr-2 file:rounded-lg file:border-0 file:bg-amber-100 file:px-3 file:py-2 file:text-xs file:font-semibold">
                    <p class="mt-1 text-xs text-amber-900">Up to 4 images, 8 MB each.</p>
                    @error($field)<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    @error($field . '.*')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
            @endforeach
        </div>
        <label class="flex items-start gap-3 rounded-xl border border-amber-200 bg-white p-3 text-sm leading-5 text-slate-700">
            <input type="checkbox" name="confirm_publication" value="1" required @checked(old('confirm_publication')) class="mt-0.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            <span>I have the student’s permission to publish this story and these images. I have checked that every uploaded document image is redacted as described above.</span>
        </label>
        @error('confirm_publication')<p class="text-sm text-rose-700">{{ $message }}</p>@enderror
    </section>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="story-sort-order" class="text-sm font-semibold text-slate-700">Homepage order</label>
            <input id="story-sort-order" type="number" name="sort_order" min="0" step="1" value="{{ old('sort_order', $story->sort_order ?? 0) }}" class="mt-1.5 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @error('sort_order')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-end">
            <input type="hidden" name="is_active" value="0">
            <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">
                <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $isEditing ? $story->is_active : true)) class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Publish on the homepage
            </label>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('success_stories.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">{{ $isEditing ? 'Save story' : 'Create story' }}</button>
    </div>
</form>

@if ($isEditing)
    <section class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 sm:p-7" aria-labelledby="current-documents-heading">
        <div>
            <h2 id="current-documents-heading" class="text-lg font-bold text-slate-900">Uploaded document images</h2>
            <p class="mt-1 text-sm text-slate-600">These redacted images appear on the public story page while the story is published.</p>
        </div>
        @if ($story->media->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($story->media as $media)
                    <article class="overflow-hidden rounded-xl border border-slate-200">
                        <a href="{{ route('success_stories.media.show', [$story, $media]) }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ route('success_stories.media.show', [$story, $media]) }}" alt="{{ $media->type_label }} image for {{ $story->name }}" class="h-48 w-full bg-slate-100 object-contain">
                        </a>
                        <div class="flex items-center justify-between gap-3 p-3">
                            <div><p class="text-sm font-semibold text-slate-900">{{ $media->type_label }}</p><p class="text-xs text-slate-500">{{ number_format($media->file_size / 1024, 0) }} KB</p></div>
                            <form method="POST" action="{{ route('success_stories.media.destroy', [$story, $media]) }}" onsubmit="return confirm('Remove this document image?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Remove</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="rounded-xl border border-dashed border-slate-300 px-4 py-8 text-center text-sm text-slate-500">No document images have been uploaded for this story.</p>
        @endif
    </section>
@endif
