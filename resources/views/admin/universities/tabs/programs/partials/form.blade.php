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
        <label for="title" class="text-sm font-medium">Program name <span class="text-rose-500">*</span></label>
        <input id="title" name="title" value="{{ $v('title') }}"
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
        <label for="field" class="text-sm font-medium">Subject / field of study</label>
        <input id="field" name="field" value="{{ $v('field') }}"
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

<section class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 lg:p-5" aria-labelledby="annual-tuition-heading">
    <div>
        <h3 id="annual-tuition-heading" class="font-semibold text-slate-900">Annual tuition</h3>
        <p class="mt-1 text-xs text-slate-500">Enter amounts in {{ $university->country?->currency ?: 'the university currency' }}. Leave blank when tuition is not confirmed.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label for="tuition_per_year_min" class="text-sm font-medium">Minimum per year</label>
        <input id="tuition_per_year_min" type="number" min="0" step="1" name="tuition_per_year_min" value="{{ $v('tuition_per_year_min') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
    <div>
        <label for="tuition_per_year_max" class="text-sm font-medium">Maximum per year</label>
        <input id="tuition_per_year_max" type="number" min="0" step="1" name="tuition_per_year_max" value="{{ $v('tuition_per_year_max') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>
</section>

<section class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 lg:p-5" aria-labelledby="semester-tuition-heading">
    <div>
        <h3 id="semester-tuition-heading" class="font-semibold text-slate-900">Semester tuition</h3>
        <p class="mt-1 text-xs text-slate-500">Add a semester fee and the number of semesters in one academic year. Annual and semester fees can both be recorded.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div>
            <label for="tuition_per_semester_min" class="text-sm font-medium">Minimum per semester</label>
            <input id="tuition_per_semester_min" type="number" min="0" step="1" name="tuition_per_semester_min" value="{{ $v('tuition_per_semester_min') }}"
                class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
        </div>
        <div>
            <label for="tuition_per_semester_max" class="text-sm font-medium">Maximum per semester</label>
            <input id="tuition_per_semester_max" type="number" min="0" step="1" name="tuition_per_semester_max" value="{{ $v('tuition_per_semester_max') }}"
                class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
        </div>
        <div>
            <label for="semesters_per_year" class="text-sm font-medium">Semesters per year</label>
            <select id="semesters_per_year" name="semesters_per_year"
                class="mt-1 w-full rounded-xl border-slate-200 bg-white focus:border-slate-400 focus:ring-slate-200">
                <option value="">Choose count</option>
                @foreach (range(1, 4) as $count)
                    <option value="{{ $count }}" @selected((string) $v('semesters_per_year') === (string) $count)>{{ $count }} {{ Str::plural('semester', $count) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</section>

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
