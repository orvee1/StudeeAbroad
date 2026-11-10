@extends('admin.layouts.app')

@section('page_title', 'Edit Homepage Slide')
@section('breadcrumb', 'Admin / Website content / Edit slide')

@section('content')
    <div class="mx-auto max-w-6xl space-y-5">
        <div>
            <a href="{{ route('home_slides.index') }}" class="inline-flex items-center rounded-lg px-1 py-1 text-sm font-semibold text-slate-600 hover:text-slate-950">← Back to homepage slider</a>
            <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-950">Edit homepage slide</h2>
            <p class="mt-1 text-sm text-slate-600">Update the image, its overlay copy, order or visibility.</p>
        </div>

        @if (session('success'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-bold">Please check the slide details:</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        @include('admin.home_slides._form', ['slide' => $slide, 'action' => route('home_slides.update', $slide)])
    </div>
@endsection
