@foreach ($universities as $u)
    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:border-[#b8cabb] hover:shadow-md">
        <div class="p-5 sm:p-6">
            <div class="flex flex-col gap-5 sm:flex-row">
                <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 text-2xl font-bold text-[#174f46]">
                    @if($u->logo_path)<img src="{{ asset('storage/' . ltrim($u->logo_path, '/')) }}" alt="{{ $u->name }} logo" class="h-full w-full object-contain p-2">@else<span aria-hidden="true">{{ mb_substr($u->name, 0, 1) }}</span>@endif
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-lg font-bold tracking-tight text-slate-950">{{ $u->name }}</h3>
                        @if ($u->is_featured)<span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800 ring-1 ring-inset ring-amber-200">Featured</span>@endif
                    </div>
                    <p class="mt-1 text-sm text-slate-600">{{ collect([$u->city?->name, $u->state?->name, $u->country?->name])->filter()->unique()->implode(', ') ?: 'Location details coming soon' }}</p>
                    <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">{{ $u->short_description ?: 'Explore this university and discover the study opportunities available to you.' }}</p>
                    <dl class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl bg-slate-50 px-4 py-3"><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Annual tuition</dt><dd class="mt-1 text-sm font-bold text-slate-900">@if ($u->tuition_min !== null || $u->tuition_max !== null){{ $u->cost_currency ?: '' }} {{ $u->tuition_min !== null ? number_format($u->tuition_min) : '—' }}–{{ $u->tuition_max !== null ? number_format($u->tuition_max) : '—' }}@else Contact university @endif</dd></div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3"><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">World ranking</dt><dd class="mt-1 text-sm font-bold text-slate-900">{{ $u->world_ranking ? '#' . number_format($u->world_ranking) : 'Not listed' }}</dd></div>
                        <div class="col-span-2 rounded-2xl bg-slate-50 px-4 py-3 sm:col-span-1"><dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Study options</dt><dd class="mt-1 text-sm font-bold text-slate-900">{{ $u->programs_count }} {{ Str::plural('program', $u->programs_count) }}</dd></div>
                    </dl>
                    <div class="mt-5 flex flex-wrap items-center gap-3"><a href="{{ route('public.universities.show', $u->slug) }}" class="inline-flex items-center justify-center rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#103e37]">View university <span class="ml-2" aria-hidden="true">→</span></a></div>
                </div>
            </div>
        </div>
    </article>
@endforeach
