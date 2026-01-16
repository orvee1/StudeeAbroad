@php
    $v = fn($key, $default = '') => old($key, $university?->{$key} ?? $default);

    $selectedCountryId = $v('country_id', '');
    $selectedStateId = $v('state_id', '');
    $selectedCityId = $v('city_id', '');
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div>
        <label class="text-sm font-medium">Country <span class="text-rose-500">*</span></label>
        <select id="country_id" name="country_id"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="">Select country</option>
            @foreach ($countries as $c)
                <option value="{{ $c->id }}" @selected((string) $selectedCountryId === (string) $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-medium">State <span class="text-rose-500">*</span></label>
        <select id="state_id" name="state_id"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="">Select state</option>
            @foreach ($states as $s)
                <option value="{{ $s->id }}" @selected((string) $selectedStateId === (string) $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-medium">City <span class="text-rose-500">*</span></label>
        <select id="city_id" name="city_id"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="">Select city</option>
            @foreach ($cities as $c)
                <option value="{{ $c->id }}" @selected((string) $selectedCityId === (string) $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Name <span class="text-rose-500">*</span></label>
        <input name="name" value="{{ $v('name') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="Harvard University" />
    </div>

    <div>
        <label class="text-sm font-medium">Slug <span class="text-rose-500">*</span></label>
        <input name="slug" value="{{ $v('slug') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="harvard-university" />
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
    <div>
        <label class="text-sm font-medium">Type</label>
        <input name="type" value="{{ $v('type') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="Public / Private" />
    </div>

    <div>
        <label class="text-sm font-medium">Established Year</label>
        <input type="number" name="established_year" value="{{ $v('established_year') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="1636" />
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_active', $university?->is_active ?? true))>
            <span class="text-sm font-medium">Active</span>
        </label>
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_featured', $university?->is_featured ?? false))>
            <span class="text-sm font-medium">Featured</span>
        </label>
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="scholarship_available" value="1" class="rounded border-slate-300"
                @checked((bool) old('scholarship_available', $university?->scholarship_available ?? false))>
            <span class="text-sm font-medium">Scholarship Available</span>
        </label>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Logo</label>
        <input type="file" name="logo" class="mt-1 block w-full text-sm" />
        @if ($university?->logo_path)
            <img class="mt-2 h-14 w-14 rounded-2xl object-cover border border-slate-200"
                src="{{ asset('storage/' . $university->logo_path) }}" alt="">
        @endif
    </div>

    <div>
        <label class="text-sm font-medium">Cover</label>
        <input type="file" name="cover" class="mt-1 block w-full text-sm" />
        @if ($university?->cover_path)
            <img class="mt-2 h-20 w-full rounded-2xl object-cover border border-slate-200"
                src="{{ asset('storage/' . $university->cover_path) }}" alt="">
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Website</label>
        <input name="website_url" value="{{ $v('website_url') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="https://example.edu" />
    </div>

    <div>
        <label class="text-sm font-medium">Email</label>
        <input name="email" value="{{ $v('email') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="info@example.edu" />
    </div>

    <div>
        <label class="text-sm font-medium">Phone</label>
        <input name="phone" value="{{ $v('phone') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="+1..." />
    </div>

    <div>
        <label class="text-sm font-medium">Address</label>
        <input name="address" value="{{ $v('address') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
    <div>
        <label class="text-sm font-medium">World Ranking</label>
        <input type="number" name="world_ranking" value="{{ $v('world_ranking') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div>
        <label class="text-sm font-medium">Acceptance Rate (%)</label>
        <input name="acceptance_rate" value="{{ $v('acceptance_rate') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="12.50" />
    </div>

    <div>
        <label class="text-sm font-medium">Sort Order</label>
        <input type="number" name="sort_order" value="{{ $v('sort_order', 0) }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>

    <div>
        <label class="text-sm font-medium">Application Fee</label>
        <input type="number" name="application_fee" value="{{ $v('application_fee') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Tuition Min</label>
        <input type="number" name="tuition_min" value="{{ $v('tuition_min') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
    <div>
        <label class="text-sm font-medium">Tuition Max</label>
        <input type="number" name="tuition_max" value="{{ $v('tuition_max') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
    <div>
        <label class="text-sm font-medium">Living Cost Min</label>
        <input type="number" name="living_cost_min" value="{{ $v('living_cost_min') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
    <div>
        <label class="text-sm font-medium">Living Cost Max</label>
        <input type="number" name="living_cost_max" value="{{ $v('living_cost_max') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Short Description</label>
        <textarea name="short_description" rows="3"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">{{ $v('short_description') }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium">Meta Title</label>
        <input name="meta_title" value="{{ $v('meta_title') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
        <div class="mt-3">
            <label class="text-sm font-medium">Meta Description</label>
            <input name="meta_description" value="{{ $v('meta_description') }}"
                class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
        </div>
    </div>
</div>

<div>
    <label class="text-sm font-medium">Full Description</label>
    <textarea name="description" rows="6"
        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">{{ $v('description') }}</textarea>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const countrySel = document.getElementById('country_id');
        const stateSel = document.getElementById('state_id');
        const citySel = document.getElementById('city_id');

        async function loadStates(countryId, keepValue = '') {
            stateSel.innerHTML = `<option value="">Select state</option>`;
            citySel.innerHTML = `<option value="">Select city</option>`;
            if (!countryId) return;

            const url = `{{ route('api.statesByCountry') }}?country_id=${countryId}`;
            const res = await fetch(url);
            const items = await res.json();

            items.forEach(i => {
                const opt = document.createElement('option');
                opt.value = i.id;
                opt.textContent = i.name;
                if (String(keepValue) === String(i.id)) opt.selected = true;
                stateSel.appendChild(opt);
            });
        }

        async function loadCities(stateId, keepValue = '') {
            citySel.innerHTML = `<option value="">Select city</option>`;
            if (!stateId) return;

            const url = `{{ route('api.citiesByState') }}?state_id=${stateId}`;
            const res = await fetch(url);
            const items = await res.json();

            items.forEach(i => {
                const opt = document.createElement('option');
                opt.value = i.id;
                opt.textContent = i.name;
                if (String(keepValue) === String(i.id)) opt.selected = true;
                citySel.appendChild(opt);
            });
        }

        countrySel?.addEventListener('change', () => loadStates(countrySel.value));
        stateSel?.addEventListener('change', () => loadCities(stateSel.value));
    });
</script>
