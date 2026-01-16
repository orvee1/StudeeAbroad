@extends('admin.layouts.app')

@section('page_title', 'Upload Media')
@section('breadcrumb', 'Admin / Universities / Media / Create')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-4 bg-white border border-slate-200 rounded-2xl p-3 flex flex-wrap gap-2">
            <a href="{{ route('universities.media.index', $university) }}"
                class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">Back to Media</a>
            <a href="{{ route('universities.show', $university) }}"
                class="px-4 py-2 rounded-xl text-sm border border-slate-200 hover:bg-slate-50">Overview</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <div class="text-xl font-semibold">Upload Media</div>
                <div class="text-sm text-slate-500">{{ $university->name }}</div>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('universities.media.store', $university) }}"
                enctype="multipart/form-data">
                @csrf
                @include('admin.universities.tabs.media.partials.form', ['media' => null])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">Upload</button>
                    <a href="{{ route('universities.media.index', $university) }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
