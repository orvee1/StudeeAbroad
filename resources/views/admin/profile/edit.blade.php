@extends('admin.layouts.app')

@section('page_title', 'Account settings')
@section('breadcrumb', 'Admin / Account / Profile')

@section('content')
    <div class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-emerald-950 to-teal-900 px-6 py-7 text-white shadow-lg shadow-emerald-950/10 sm:px-8 sm:py-8">
        <p class="text-xs font-extrabold uppercase tracking-[.18em] text-emerald-200">Administrator account</p>
        <h2 class="mt-2 text-2xl font-extrabold tracking-tight sm:text-3xl">Manage your profile</h2>
        <p class="mt-2 max-w-2xl text-sm leading-6 text-emerald-50/80">Update the account details and password used to access the EXFREELANCE admin workspace.</p>
    </div>

    <div class="grid gap-5 xl:grid-cols-2">
        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7" aria-labelledby="profile-information-heading">
            <div class="mb-5 flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-800">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/></svg>
                </span>
                <div>
                    <h3 id="profile-information-heading" class="text-lg font-extrabold tracking-tight text-slate-950">Profile information</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-500">Manage your display name and email address.</p>
                </div>
            </div>
            @include('profile.partials.update-profile-information-form', ['hideProfileSectionHeader' => true])
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7" aria-labelledby="update-password-heading">
            <div class="mb-5 flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="4.5" y="10" width="15" height="10" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v2"/></svg>
                </span>
                <div>
                    <h3 id="update-password-heading" class="text-lg font-extrabold tracking-tight text-slate-950">Update password</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-500">Choose a strong password to protect admin access.</p>
                </div>
            </div>
            @include('profile.partials.update-password-form', ['hideProfileSectionHeader' => true])
        </section>

        <section class="rounded-3xl border border-rose-200 bg-white p-5 shadow-sm sm:p-7 xl:col-span-2" aria-labelledby="delete-account-heading">
            <div class="mb-5 flex items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7h15m-13.5 0 .8 13h10.4L18 7M9 7V4.5h6V7m-5 4v5m4-5v5"/></svg>
                </span>
                <div>
                    <h3 id="delete-account-heading" class="text-lg font-extrabold tracking-tight text-slate-950">Delete account</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-500">This removes the signed-in administrator account and its account data.</p>
                </div>
            </div>
            @include('profile.partials.delete-user-form', ['hideProfileSectionHeader' => true])
        </section>
    </div>
@endsection
