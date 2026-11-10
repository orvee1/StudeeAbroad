@extends('admin.layouts.app')

@section('page_title', 'Add Program')
@section('breadcrumb', 'Admin / Universities / Programs / Create')

@section('content')
    <div class="max-w-5xl">
        <div class="mb-4 bg-white border border-slate-200 rounded-2xl p-3 flex flex-wrap gap-2">
            <a href="{{ route('universities.programs.index', $university) }}"
                class="px-4 py-2 rounded-xl text-sm border border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">Back to Programs</a>
            <a href="{{ route('universities.show', $university) }}"
                class="px-4 py-2 rounded-xl text-sm border border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">Overview</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <div class="text-xl font-semibold">Create Program</div>
                <div class="text-sm text-slate-500">{{ $university->name }}</div>
            </div>

            <form class="p-5 space-y-5" method="POST"
                action="{{ route('universities.programs.store', $university) }}">
                @csrf
                @include('admin.universities.tabs.programs.partials.form', [
                    'program' => null,
                    'intakeOptions' => $intakeOptions,
                ])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Save</button>
                    <a href="{{ route('universities.programs.index', $university) }}"
                        class="px-5 py-2.5 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
