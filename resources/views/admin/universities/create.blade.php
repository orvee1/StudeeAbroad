@extends('admin.layouts.app')

@section('page_title', 'Add University')
@section('breadcrumb', 'Admin / Universities / Create')

@section('content')
    <div class="max-w-5xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <div class="text-xl font-semibold">Create University</div>
                <div class="text-sm text-slate-500">Add a university under a city.</div>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('universities.store') }}"
                enctype="multipart/form-data">
                @csrf
                @include('admin.universities.partials.form', [
                    'university' => null,
                    'countries' => $countries,
                    'states' => $states,
                    'cities' => $cities,
                ])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Save University
                    </button>
                    <a href="{{ route('universities.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
