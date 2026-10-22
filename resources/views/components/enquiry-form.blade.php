@props(['country' => null, 'university' => null, 'program' => null, 'source' => 'landing'])

<section id="enquiry" class="rounded-3xl border border-[#dce5dc] bg-white p-6 shadow-sm sm:p-8">
    <div class="max-w-xl">
        <p class="text-xs font-bold uppercase tracking-[.16em] text-[#b96748]">Talk with our team</p>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-[#183b36]">Get guidance for your next step</h2>
        <p class="mt-2 text-sm leading-6 text-[#687871]">Share a few details and our team can help you understand the options.</p>
    </div>

    @if (session('success'))
        <div role="status" class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div role="alert" class="mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-semibold">Please check the form:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('enquiries.store') }}" class="mt-6 grid gap-4 sm:grid-cols-2">
        @csrf
        <input type="hidden" name="source" value="{{ $source }}">
        @if ($country)
            <input type="hidden" name="desired_country_id" value="{{ $country->id }}">
        @endif
        @if ($university)
            <input type="hidden" name="desired_university_id" value="{{ $university->id }}">
        @endif
        @if ($program)
            <input type="hidden" name="desired_level" value="{{ $program->level }}">
            @if ($program->intake_months && count($program->intake_months))
                <input type="hidden" name="preferred_intake" value="{{ $program->intake_months[0] }}">
            @endif
        @endif
        <div>
            <label for="enquiry-name" class="text-sm font-semibold text-[#52665f]">Your name</label>
            <input id="enquiry-name" name="name" required maxlength="255" value="{{ old('name', auth()->user()->name ?? '') }}" autocomplete="name" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
        </div>
        <div>
            <label for="enquiry-email" class="text-sm font-semibold text-[#52665f]">Email address</label>
            <input id="enquiry-email" type="email" name="email" required maxlength="255" value="{{ old('email', auth()->user()->email ?? '') }}" autocomplete="email" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
        </div>
        <div>
            <label for="enquiry-phone" class="text-sm font-semibold text-[#52665f]">Phone <span class="font-normal text-[#819087]">(optional)</span></label>
            <input id="enquiry-phone" type="tel" name="phone" maxlength="30" value="{{ old('phone', auth()->user()->phone ?? '') }}" autocomplete="tel" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
        </div>
        @unless ($country)
            <div>
                <label for="enquiry-country" class="text-sm font-semibold text-[#52665f]">Preferred destination</label>
                <select id="enquiry-country" name="desired_country_id" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white focus:border-[#4e8273] focus:ring-[#4e8273]">
                    <option value="">Choose a country (optional)</option>
                    @foreach (\App\Models\Country::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']) as $option)
                        <option value="{{ $option->id }}" @selected(old('desired_country_id') == $option->id)>{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>
        @endunless
        @unless ($university)
            <div>
                <label for="enquiry-level" class="text-sm font-semibold text-[#52665f]">Study level <span class="font-normal text-[#819087]">(optional)</span></label>
                <select id="enquiry-level" name="desired_level" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white focus:border-[#4e8273] focus:ring-[#4e8273]">
                    <option value="">Select a level</option>
                    @foreach (['Bachelor', 'Master', 'PhD', 'Diploma'] as $level)
                        <option value="{{ $level }}" @selected(old('desired_level') === $level)>{{ $level }}</option>
                    @endforeach
                </select>
            </div>
        @endunless
        <div class="sm:col-span-2">
            <label for="enquiry-message" class="text-sm font-semibold text-[#52665f]">What would you like help with? <span class="font-normal text-[#819087]">(optional)</span></label>
            <textarea id="enquiry-message" name="message" rows="3" maxlength="2000" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">{{ old('message') }}</textarea>
        </div>
        <div class="sm:col-span-2">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#174f46] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#103e37]">Request guidance <span aria-hidden="true">→</span></button>
        </div>
    </form>
</section>
