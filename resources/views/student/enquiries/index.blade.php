@extends('student.layouts.app')

@section('page_title', 'My enquiries')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-semibold uppercase tracking-wide text-[#b96748]">Your study-abroad journey</p><h1 class="mt-2 text-3xl font-bold tracking-tight text-[#183b36]">My enquiries</h1><p class="mt-2 text-sm text-[#71817a]">Follow the guidance requests sent from your account email.</p></div><a href="{{ route('public.programs.index') }}" class="inline-flex rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-semibold text-white">Explore programs</a></div>
        @if (session('success'))<div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>@endif
        <div class="space-y-3">
            @forelse($enquiries as $enquiry)
                <article class="rounded-2xl border border-[#e5e5dc] bg-white p-5 sm:p-6"><div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"><div><p class="text-xs text-[#819087]">Submitted {{ $enquiry->created_at?->format('d M Y') }}</p><h2 class="mt-1 text-lg font-bold text-[#183b36]">{{ $enquiry->desiredUniversity?->name ?: 'Study guidance request' }}</h2><p class="mt-1 text-sm text-[#687871]">{{ collect([$enquiry->desiredCountry?->name, $enquiry->desired_level, $enquiry->preferred_intake])->filter()->implode(' · ') ?: 'General enquiry' }}</p></div><span class="self-start rounded-full bg-[#edf4eb] px-3 py-1.5 text-xs font-semibold capitalize text-[#38665a]">{{ $enquiry->status }}</span></div>@if($enquiry->message)<p class="mt-4 border-t border-[#eeeee8] pt-4 text-sm leading-6 text-[#687871]">{{ $enquiry->message }}</p>@endif</article>
            @empty
                <div class="rounded-2xl border border-dashed border-[#d5ddd2] bg-white px-6 py-12 text-center"><span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#edf4eb] text-xl text-[#38665a]" aria-hidden="true">✉</span><h2 class="mt-4 font-bold text-[#183b36]">No enquiries yet</h2><p class="mx-auto mt-2 max-w-md text-sm text-[#71817a]">Browse programs and universities. If you ask for guidance using this email address, your enquiry will show here.</p><a href="{{ route('public.programs.index') }}" class="mt-5 inline-flex rounded-xl bg-[#174f46] px-4 py-2.5 text-sm font-semibold text-white">Explore programs</a></div>
            @endforelse
        </div>
        @if($enquiries->hasPages()){{ $enquiries->links() }}@endif
    </div>
@endsection
