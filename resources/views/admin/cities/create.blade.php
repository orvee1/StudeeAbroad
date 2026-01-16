@extends('admin.layouts.app')

@section('page_title', 'Add City')
@section('breadcrumb', 'Admin / Cities / Create')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200">
                <div class="text-xl font-semibold">Create City</div>
                <div class="text-sm text-slate-500">Add a new city under a state.</div>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('cities.store') }}">
                @csrf
                @include('admin.cities.partials.form', [
                    'city' => null,
                    'countries' => $countries,
                    'states' => $states,
                ])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Save City
                    </button>
                    <a href="{{ route('cities.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
