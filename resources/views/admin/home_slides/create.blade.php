@extends('admin.layouts.app')

@section('page_title', 'Add Homepage Slide')
@section('breadcrumb', 'Admin / Website content / Add slide')

@section('content')
    <div class="mx-auto max-w-6xl space-y-5">
        <div>
            <a href="{{ route('home_slides.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-200 hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"">← Back to homepage slider</a>
            <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-950">Add a homepage slide</h2>
            <p class="mt-1 text-sm text-slate-600">Upload the image, add its overlay copy, then choose whether to publish it.</p>
        </div>

        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-bold">Please check the slide details:</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        @include('admin.home_slides._form', ['slide' => null, 'action' => route('home_slides.store')])
    </div>
@endsection
