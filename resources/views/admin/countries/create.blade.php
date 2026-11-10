@extends('admin.layouts.app')

@section('page_title', 'Add Country')
@section('breadcrumb', 'Admin / Countries / Create')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <div class="text-xl font-semibold">Create Country</div>
                <div class="text-sm text-slate-500">Add a new country for your study abroad platform.</div>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('countries.store') }}"
                enctype="multipart/form-data">
                @csrf
                @include('admin.countries.partials.form', ['country' => null])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Save Country
                    </button>
                    <a href="{{ route('countries.index') }}"
                        class="px-5 py-2.5 rounded-xl border text-sm border-slate-300 bg-slate-50 text-slate-800 font-semibold shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
