@php
    $v = fn($key, $default = '') => old($key, $country?->{$key} ?? $default);
@endphp

@if ($errors->any())
    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
        <div class="font-semibold mb-1">Please fix the errors:</div>
        <ul class="list-disc pl-5 text-sm">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Name <span class="text-rose-500">*</span></label>
        <input name="name" value="{{ $v('name') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="United States" />
    </div>

    <div>
        <label class="text-sm font-medium">Slug <span class="text-rose-500">*</span></label>
        <input name="slug" value="{{ $v('slug') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="united-states" />
        <div class="text-xs text-slate-500 mt-1">Unique slug required</div>
    </div>

    <div>
        <label class="text-sm font-medium">ISO2</label>
        <input name="iso2" value="{{ $v('iso2') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="US" />
    </div>

    <div>
        <label class="text-sm font-medium">ISO3</label>
        <input name="iso3" value="{{ $v('iso3') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="USA" />
    </div>

    <div>
        <label class="text-sm font-medium">Currency</label>
        <input name="currency" value="{{ $v('currency') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="USD" />
    </div>

    <div>
        <label class="text-sm font-medium">Phone Code</label>
        <input name="phone_code" value="{{ $v('phone_code') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="+1" />
    </div>

    <div>
        <label class="text-sm font-medium">Sort Order</label>
        <input type="number" name="sort_order" value="{{ $v('sort_order', 0) }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_active', $country?->is_active ?? true))>
            <span class="text-sm font-medium">Active</span>
        </label>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Flag Image</label>
        <input type="file" name="flag" class="mt-1 block w-full text-sm" />
        <div class="text-xs text-slate-500 mt-1">jpg/png/webp (max 2MB)</div>
    </div>

    <div class="flex items-center gap-3 md:justify-end">
        @if ($country?->flag_path)
            <img class="h-14 w-14 rounded-2xl object-cover border border-slate-200"
                src="{{ asset('storage/' . $country->flag_path) }}" alt="">
            <div class="text-xs text-slate-500 break-all">{{ $country->flag_path }}</div>
        @else
            <div class="text-xs text-slate-500">No flag uploaded yet.</div>
        @endif
    </div>
</div>

<div>
    <label class="text-sm font-medium">Description</label>
    <textarea name="description" rows="4"
        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
        placeholder="Short description...">{{ $v('description') }}</textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Meta Title</label>
        <input name="meta_title" value="{{ $v('meta_title') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div>
        <label class="text-sm font-medium">Meta Description</label>
        <input name="meta_description" value="{{ $v('meta_description') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>
