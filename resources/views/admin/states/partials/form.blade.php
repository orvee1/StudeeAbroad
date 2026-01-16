@php
    $v = fn($key, $default = '') => old($key, $state?->{$key} ?? $default);
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
        <label class="text-sm font-medium">Country <span class="text-rose-500">*</span></label>
        <select name="country_id"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="">Select country</option>
            @foreach ($countries as $c)
                <option value="{{ $c->id }}" @selected((string) $v('country_id') === (string) $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_active', $state?->is_active ?? true))>
            <span class="text-sm font-medium">Active</span>
        </label>
    </div>

    <div>
        <label class="text-sm font-medium">Name <span class="text-rose-500">*</span></label>
        <input name="name" value="{{ $v('name') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="California" />
    </div>

    <div>
        <label class="text-sm font-medium">Slug <span class="text-rose-500">*</span></label>
        <input name="slug" value="{{ $v('slug') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="california" />
    </div>

    <div>
        <label class="text-sm font-medium">Code</label>
        <input name="code" value="{{ $v('code') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="CA" />
    </div>

    <div>
        <label class="text-sm font-medium">Sort Order</label>
        <input type="number" name="sort_order" value="{{ $v('sort_order', 0) }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>

<div>
    <label class="text-sm font-medium">Description</label>
    <textarea name="description" rows="4"
        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
        placeholder="Short description...">{{ $v('description') }}</textarea>
</div>
