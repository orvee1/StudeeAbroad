@php
    $v = fn($key, $default = '') => old($key, $city?->{$key} ?? $default);
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

@php
    // derive selected country from current city->state->country_id if available
    $selectedCountryId = old('country_id') ?? ($city?->state?->country_id ?? (request('country_id') ?? ''));
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm font-medium">Country</label>
        <select id="country_id"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="">Select country</option>
            @foreach ($countries as $c)
                <option value="{{ $c->id }}" @selected((string) $selectedCountryId === (string) $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        <div class="text-xs text-slate-500 mt-1">Country select is for loading states</div>
    </div>

    <div class="flex items-end gap-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                @checked((bool) old('is_active', $city?->is_active ?? true))>
            <span class="text-sm font-medium">Active</span>
        </label>
    </div>

    <div>
        <label class="text-sm font-medium">State <span class="text-rose-500">*</span></label>
        <select id="state_id" name="state_id"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
            <option value="">Select state</option>
            @foreach ($states as $s)
                <option value="{{ $s->id }}" @selected((string) $v('state_id') === (string) $s->id)>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-medium">Name <span class="text-rose-500">*</span></label>
        <input name="name" value="{{ $v('name') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="Los Angeles" />
    </div>

    <div>
        <label class="text-sm font-medium">Slug <span class="text-rose-500">*</span></label>
        <input name="slug" value="{{ $v('slug') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="los-angeles" />
    </div>

    <div>
        <label class="text-sm font-medium">Latitude</label>
        <input name="latitude" value="{{ $v('latitude') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="34.052235" />
    </div>

    <div>
        <label class="text-sm font-medium">Longitude</label>
        <input name="longitude" value="{{ $v('longitude') }}"
            class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200"
            placeholder="-118.243683" />
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const countrySel = document.getElementById('country_id');
        const stateSel = document.getElementById('state_id');
        if (!countrySel || !stateSel) return;

        countrySel.addEventListener('change', async () => {
            const countryId = countrySel.value;
            stateSel.innerHTML = `<option value="">Select state</option>`;
            if (!countryId) return;

            const url = `{{ route('api.statesByCountry') }}?country_id=${countryId}`;
            const res = await fetch(url);
            const states = await res.json();

            states.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.name;
                stateSel.appendChild(opt);
            });
        });
    });
</script>
