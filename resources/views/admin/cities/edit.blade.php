@extends('admin.layouts.app')

@section('page_title', 'Edit City')
@section('breadcrumb', 'Admin / Cities / Edit')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-start justify-between gap-3">
                <div>
                    <div class="text-xl font-semibold">Edit City</div>
                    <div class="text-sm text-slate-500">{{ $city->name }}</div>
                </div>
                <a href="{{ route('cities.show', $city) }}"
                    class="px-4 py-2 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                    View Details
                </a>
            </div>

            <form class="p-5 space-y-5" method="POST" action="{{ route('cities.update', $city) }}">
                @csrf
                @method('PUT')

                @include('admin.cities.partials.form', [
                    'city' => $city,
                    'countries' => $countries,
                    'states' => $states,
                ])

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-sm hover:opacity-90">
                        Update City
                    </button>
                    <a href="{{ route('cities.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm hover:bg-slate-50">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
