@extends('admin.layouts.app')

@section('page_title', 'Add State')
@section('breadcrumb', 'Admin / States / Create')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <div class="text-xl font-semibold">Create State</div>
                <div class="text-sm text-slate-500">Add a new state under a country.</div>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('states.store') }}">
                @csrf
                @include('admin.states.partials.form', ['state' => null, 'countries' => $countries])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Save State
                    </button>
                    <a href="{{ route('states.index') }}"
                        class="px-5 py-2.5 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
