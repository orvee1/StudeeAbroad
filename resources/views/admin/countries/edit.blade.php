@extends('admin.layouts.app')

@section('page_title', 'Edit Country')
@section('breadcrumb', 'Admin / Countries / Edit')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-start justify-between gap-3">
                <div>
                    <div class="text-xl font-semibold">Edit Country</div>
                    <div class="text-sm text-slate-500">{{ $country->name }}</div>
                </div>
                <a href="{{ route('countries.show', $country) }}"
                    class="px-4 py-2 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">
                    View Details
                </a>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('countries.update', $country) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.countries.partials.form', ['country' => $country])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Update Country
                    </button>
                    <a href="{{ route('countries.index') }}"
                        class="px-5 py-2.5 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
