@extends('admin.layouts.app')

@section('page_title', 'Edit Success Story')
@section('breadcrumb', 'Admin / Success Stories / Edit')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div>
            <a href="{{ route('success_stories.index') }}" class="text-sm font-semibold px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-slate-800 shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 inline-flex items-center justify-center">← Back to success stories</a>
            <h1 class="mt-3 text-2xl font-bold text-slate-900">Edit {{ $story->name }}’s story</h1>
            <p class="mt-1 text-sm text-slate-600">Manage the story, public visibility, and shared evidence images.</p>
            @if($story->is_active)<a href="{{ route('public.success_stories.show', $story) }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex text-sm font-semibold px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-slate-800 shadow-sm transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2 items-center justify-center">View public story ↗</a>@endif
        </div>

        @if (session('success'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-semibold">Please check the form:</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        @include('admin.success_stories._form', ['story' => $story, 'action' => route('success_stories.update', $story)])
    </div>
@endsection
