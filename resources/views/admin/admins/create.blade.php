@extends('admin.layouts.app')

@section('page_title', 'Create Admin')
@section('breadcrumb', 'Admin / Administrators / Create')

@section('content')
    <div class="max-w-4xl overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <div class="border-b border-slate-200 p-5">
            <h1 class="text-xl font-semibold">Create Administrator Account</h1>
            <p class="mt-1 text-sm text-slate-500">This account will have access to the admin panel.</p>
        </div>

        <form class="space-y-5 p-5" method="POST" action="{{ route('admins.store') }}">
            @csrf

            @if ($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="mt-1 list-inside list-disc text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="name" class="text-sm font-medium">Full name <span class="text-rose-500">*</span></label>
                    <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                    @error('name') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="text-sm font-medium">Email <span class="text-rose-500">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                    @error('email') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="text-sm font-medium">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                    @error('phone') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="text-sm font-medium">Password <span class="text-rose-500">*</span></label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                    @error('password') <p class="mt-1 text-sm text-rose-700">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="text-sm font-medium">Confirm password <span class="text-rose-500">*</span></label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-1 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200" />
                </div>
            </div>

            <div class="flex items-center gap-2 border-t border-slate-100 pt-4">
                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm text-white hover:opacity-90">
                    Create Admin
                </button>
                <a href="{{ route('admins.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
