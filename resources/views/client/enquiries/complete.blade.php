<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Complete your student guidance request.">
    <title>Student details — {{ config('app.name', 'EXFREELANCE') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="brand-theme min-h-screen bg-[#fffaf5] font-sans text-[#133f39] antialiased">
    <header class="border-b border-[#ebe4d9] bg-white/90">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="{{ route('home') }}" aria-label="{{ config('app.name', 'EXFREELANCE') }} home">
                <x-brand-mark size="h-12 w-48" wrapper-class="rounded-lg ring-0 bg-transparent" />
            </a>
            <a href="{{ route('home') }}#enquiry" class="text-sm font-semibold text-[#0757a6] hover:text-[#142b4a]">Back to home</a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14">
        <div class="mx-auto max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-[.16em] text-[#d96545]">Personal guidance · Step 2 of 2</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight text-[#142b4a] sm:text-4xl">Tell us a little more about you.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-[#58718a]">Your contact details are filled in from the first step. Complete your student profile so our team can give you relevant guidance.</p>

            @if ($errors->any())
                <div role="alert" class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Please check the form:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('enquiries.complete.store') }}" class="mt-7 rounded-[1.5rem] border border-[#dce8f1] bg-white p-5 shadow-xl shadow-[#142b4a]/10 sm:p-8">
                @csrf
                <input type="hidden" name="draft_token" value="{{ $draft }}">

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="student-name" class="text-sm font-semibold text-[#52665f]">Your name</label>
                        <input id="student-name" name="name" required maxlength="255" value="{{ old('name', $draftData['name'] ?? '') }}" autocomplete="name" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
                        @error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-email" class="text-sm font-semibold text-[#52665f]">Email address</label>
                        <input id="student-email" type="email" name="email" required maxlength="255" value="{{ old('email', $draftData['email'] ?? '') }}" autocomplete="email" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
                        @error('email')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-phone" class="text-sm font-semibold text-[#52665f]">Phone <span class="font-normal text-[#819087]">(optional)</span></label>
                        <input id="student-phone" type="tel" name="phone" maxlength="30" value="{{ old('phone', $draftData['phone'] ?? '') }}" autocomplete="tel" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
                        @error('phone')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-gender" class="text-sm font-semibold text-[#52665f]">Gender <span class="font-normal text-[#819087]">(optional)</span></label>
                        <select id="student-gender" name="gender" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white focus:border-[#4e8273] focus:ring-[#4e8273]">
                            <option value="">Choose an option</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender }}" @selected(old('gender') === $gender)>{{ $gender }}</option>
                            @endforeach
                        </select>
                        @error('gender')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-date-of-birth" class="text-sm font-semibold text-[#52665f]">Date of birth <span class="font-normal text-[#819087]">(optional)</span></label>
                        <input id="student-date-of-birth" type="date" name="date_of_birth" max="{{ now()->toDateString() }}" value="{{ old('date_of_birth') }}" autocomplete="bday" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
                        @error('date_of_birth')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-district" class="text-sm font-semibold text-[#52665f]">Which district do you live in? <span class="font-normal text-[#819087]">(optional)</span></label>
                        <select id="student-district" name="district" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white focus:border-[#4e8273] focus:ring-[#4e8273]">
                            <option value="">Choose a district</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                            @endforeach
                        </select>
                        @error('district')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-education" class="text-sm font-semibold text-[#52665f]">Highest education qualification <span class="font-normal text-[#819087]">(optional)</span></label>
                        <select id="student-education" name="highest_education" class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white focus:border-[#4e8273] focus:ring-[#4e8273]">
                            <option value="">Choose a qualification</option>
                            @foreach ($qualifications as $qualification)
                                <option value="{{ $qualification }}" @selected(old('highest_education') === $qualification)>{{ $qualification }}</option>
                            @endforeach
                        </select>
                        @error('highest_education')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="student-passing-year" class="text-sm font-semibold text-[#52665f]">Passing year of highest qualification <span class="font-normal text-[#819087]">(optional)</span></label>
                        <input id="student-passing-year" type="number" name="highest_education_passing_year" min="1950" max="{{ now()->year }}" step="1" value="{{ old('highest_education_passing_year') }}" inputmode="numeric" placeholder="e.g. {{ now()->year - 1 }}" class="mt-1.5 w-full rounded-xl border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273]">
                        @error('highest_education_passing_year')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="student-proficiency" class="text-sm font-semibold text-[#52665f]">Which English proficiency test do you have? <span class="text-rose-600" aria-label="required">*</span></label>
                        <select id="student-proficiency" name="english_proficiency" required class="mt-1.5 w-full rounded-xl border-[#dfe5df] bg-white focus:border-[#4e8273] focus:ring-[#4e8273]">
                            <option value="">Choose an option</option>
                            @foreach ($proficiencies as $proficiency)
                                <option value="{{ $proficiency }}" @selected(old('english_proficiency') === $proficiency)>{{ $proficiency }}</option>
                            @endforeach
                        </select>
                        @error('english_proficiency')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                @if ($desiredCountryName || $desiredUniversityName || !empty($draftData['desired_level']) || !empty($draftData['preferred_intake']) || !empty($draftData['message']))
                    <div class="mt-6 rounded-xl bg-[#f5f9fb] px-4 py-3 text-sm leading-6 text-[#58718a]">
                        <span class="font-semibold text-[#142b4a]">From your first step:</span>
                        <p>{{ collect([$desiredUniversityName, $desiredCountryName, $draftData['desired_level'] ?? null, $draftData['preferred_intake'] ?? null])->filter()->implode(' · ') }}</p>
                        @if (!empty($draftData['message']))<p class="mt-1 whitespace-pre-line">{{ $draftData['message'] }}</p>@endif
                    </div>
                @endif

                <div class="mt-7 flex flex-col-reverse gap-3 border-t border-[#edf0ec] pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('home') }}#enquiry" class="text-center text-sm font-semibold text-[#0757a6] hover:text-[#142b4a]">Back to first step</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#174f46] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#103e37]">Submit request <span aria-hidden="true">→</span></button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
