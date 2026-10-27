@props(['country' => null, 'university' => null, 'program' => null, 'source' => 'landing'])

<section id="enquiry" class="relative isolate scroll-mt-28 overflow-hidden rounded-[2rem] border border-[#cfe1ec] bg-gradient-to-br from-[#eaf7ff] via-white to-[#fff3e4] p-5 shadow-[0_24px_70px_-36px_rgba(7,87,166,.35)] sm:p-8 lg:p-10">
    <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full bg-[#0aa9cf]/10 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-[#ef8b22]/10 blur-3xl" aria-hidden="true"></div>

    <div class="relative grid gap-8 lg:grid-cols-[.8fr_1.2fr] lg:items-center lg:gap-12">
        <div class="max-w-lg">
            <p class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[.16em] text-[#0757a6]">
                <span class="h-2 w-2 rounded-full bg-[#ef8b22]"></span> Talk with our team
            </p>
            <h2 class="mt-3 text-3xl font-semibold leading-tight tracking-tight text-[#142b4a] sm:text-4xl">Get a clearer plan for your study abroad journey.</h2>
            <p class="mt-4 text-base leading-7 text-[#58718a]">Tell us what you’re looking for. Our team can help you explore destinations, universities, and next steps that fit your plans.</p>
            <ul class="mt-6 space-y-3 text-sm font-medium text-[#365d7e]">
                <li class="flex items-start gap-3"><span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#e3f4e8] text-xs font-bold text-[#198b54]" aria-hidden="true">✓</span><span>Explore destinations that fit your goals</span></li>
                <li class="flex items-start gap-3"><span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#e8faff] text-xs font-bold text-[#0757a6]" aria-hidden="true">✓</span><span>Talk through universities and study options</span></li>
                <li class="flex items-start gap-3"><span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#fff3df] text-xs font-bold text-[#c56c12]" aria-hidden="true">✓</span><span>Work out a clearer next step for your application</span></li>
            </ul>
        </div>

        <div class="rounded-[1.5rem] border border-[#dce8f1] bg-white/95 p-5 shadow-xl shadow-[#142b4a]/10 sm:p-7">
            <p class="text-sm font-bold text-[#142b4a]">Request personal guidance</p>
            <p class="mt-1 text-sm text-[#71879b]">Share a few details so we know how to help.</p>

            @if (session('success'))
                <div role="status" class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div role="alert" class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Please check the form:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('enquiries.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
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
        </div>
    </div>
</section>
