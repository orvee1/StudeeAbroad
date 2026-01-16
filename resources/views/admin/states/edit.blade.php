@extends('admin.layouts.app')

@section('page_title', 'Edit State')
@section('breadcrumb', 'Admin / States / Edit')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-start justify-between gap-3">
                <div>
                    <div class="text-xl font-semibold">Edit State</div>
                    <div class="text-sm text-slate-500">{{ $state->name }}</div>
                </div>
                <a href="{{ route('states.show', $state) }}"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                    View Details
                </a>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('states.update', $state) }}">
                @csrf
                @method('PUT')

                @include('admin.states.partials.form', ['state' => $state, 'countries' => $countries])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Update State
                    </button>
                    <a href="{{ route('states.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
