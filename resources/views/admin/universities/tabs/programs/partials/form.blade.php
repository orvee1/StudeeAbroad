@php
    $v = fn($key, $default = '') => old($key, $program?->{$key} ?? $default);
    $selectedIntakes = old('intake_months', $program?->intake_months ?? []);
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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Title <span class="text-rose-500">*</span></label>
        <input name="title" value="{{ $v('title') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="BSc in Computer Science" />
    </div>

    <div>
        <label class="text-sm font-medium">Slug <span class="text-rose-500">*</span></label>
        <input name="slug" value="{{ $v('slug') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="bsc-computer-science" />
    </div>

    <div>
        <label class="text-sm font-medium">Level <span class="text-rose-500">*</span></label>
        <input name="level" value="{{ $v('level') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="Undergraduate / Graduate / PhD" />
    </div>

    <div>
        <label class="text-sm font-medium">Field</label>
        <input name="field" value="{{ $v('field') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="Engineering / Business" />
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
    <div>
        <label class="text-sm font-medium">Duration (months)</label>
        <input type="number" name="duration_months" value="{{ $v('duration_months') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="48" />
    </div>

    <div>
        <label class="text-sm font-medium">Language</label>
        <input name="language" value="{{ $v('language') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="English" />
    </div>

    <div>
        <label class="text-sm font-medium">Sort Order</label>
        <input type="number" name="sort_order" value="{{ $v('sort_order', 0) }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_active', $program?->is_active ?? true))>
            <span class="text-sm font-medium">Active</span>
        </label>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Tuition per year (min)</label>
        <input type="number" name="tuition_per_year_min" value="{{ $v('tuition_per_year_min') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
    <div>
        <label class="text-sm font-medium">Tuition per year (max)</label>
        <input type="number" name="tuition_per_year_max" value="{{ $v('tuition_per_year_max') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>

<div>
    <label class="text-sm font-medium">Intake Months</label>
    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
        @foreach ($intakeOptions as $m)
            <label
                class="flex items-center gap-2 border border-slate-200 rounded-xl px-3 py-2 text-sm hover:bg-slate-50">
                <input type="checkbox" name="intake_months[]" value="{{ $m }}"
                    class="rounded border-slate-300" @checked(in_array($m, (array) $selectedIntakes, true))>
                <span>{{ $m }}</span>
            </label>
        @endforeach
    </div>
    <div class="text-xs text-slate-500 mt-1">Saved as JSON array in DB</div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Entry Requirements</label>
        <textarea name="entry_requirements" rows="5"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">{{ $v('entry_requirements') }}</textarea>
    </div>
    <div>
        <label class="text-sm font-medium">Notes</label>
        <textarea name="notes" rows="5"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">{{ $v('notes') }}</textarea>
    </div>
</div>
