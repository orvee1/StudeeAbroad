@extends('student.layouts.app')

@section('page_title', 'My profile')

@section('content')
    <div class="space-y-6 sm:space-y-8">
        <section class="relative isolate overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0b6158] via-[#0f6b60] to-[#083f3a] px-6 py-7 text-white shadow-xl shadow-[#0b6158]/15 sm:px-8 sm:py-9 lg:px-10">
            <div class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-32 right-20 h-64 w-64 rounded-full border border-[#ffb18e]/20"></div>
            <div class="relative flex flex-col gap-7 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white/15 text-2xl font-extrabold text-white ring-1 ring-white/25 sm:h-20 sm:w-20 sm:rounded-3xl sm:text-3xl">
                        @if ($user->profile_photo_path)
                            <img src="{{ asset('storage/' . ltrim($user->profile_photo_path, '/')) }}" alt="{{ $user->name }} profile photo" class="h-full w-full object-cover">
                        @else
                            {{ mb_strtoupper(mb_substr($user->name ?: 'S', 0, 1)) }}
                        @endif
                    </span>
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[.18em] text-[#b9f0d2]">Student account</p>
                        <h1 class="mt-2 text-2xl font-extrabold tracking-tight sm:text-3xl">Make your profile yours</h1>
                        <p class="mt-2 max-w-xl text-sm leading-6 text-white/75">Keep your contact details current so our guidance team can connect you with the right study options.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 lg:justify-end">
                    <a href="{{ route('student.enquiries.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#ff9e76] px-4 py-2.5 text-sm font-extrabold text-[#133f39] transition hover:bg-[#ffb18e] focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#0b6158]">View my enquiries</a>
                    <a href="{{ route('search') }}" class="inline-flex items-center justify-center rounded-xl border border-white/30 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#0b6158]">Browse universities</a>
                </div>
            </div>
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.12fr_.88fr]">
            <section class="rounded-3xl border border-[#eadfd3] bg-white p-5 shadow-sm sm:p-7" aria-labelledby="profile-information-heading">
                <div class="mb-6 flex items-start gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#e3f4e8] text-[#0b6158]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/></svg>
                    </span>
                    <div>
                        <h2 id="profile-information-heading" class="text-lg font-extrabold tracking-tight text-[#133f39]">Profile information</h2>
                        <p class="mt-1 text-sm leading-6 text-[#6c7d76]">Update your name, email and profile photo.</p>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form', ['hideProfileSectionHeader' => true])
            </section>

            <section class="rounded-3xl border border-[#eadfd3] bg-white p-5 shadow-sm sm:p-7" aria-labelledby="update-password-heading">
                <div class="mb-6 flex items-start gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#fff0e8] text-[#bd5d3e]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4.5" y="10" width="15" height="10" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v2"/></svg>
                    </span>
                    <div>
                        <h2 id="update-password-heading" class="text-lg font-extrabold tracking-tight text-[#133f39]">Update password</h2>
                        <p class="mt-1 text-sm leading-6 text-[#6c7d76]">Use a strong password to keep your account protected.</p>
                    </div>
                </div>
                @include('profile.partials.update-password-form', ['hideProfileSectionHeader' => true])
            </section>

            <section class="rounded-3xl border border-[#f1d8d2] bg-[#fffaf8] p-5 shadow-sm sm:p-7 xl:col-span-2" aria-labelledby="delete-account-heading">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#fde8e5] text-[#b24b43]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7h15m-13.5 0 .8 13h10.4L18 7M9 7V4.5h6V7m-5 4v5m4-5v5"/></svg>
                        </span>
                        <div>
                            <h2 id="delete-account-heading" class="text-lg font-extrabold tracking-tight text-[#133f39]">Delete account</h2>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-[#7c716d]">Deleting your account permanently removes your profile and saved activity. You will be asked to confirm your password.</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        @include('profile.partials.delete-user-form', ['hideProfileSectionHeader' => true])
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
