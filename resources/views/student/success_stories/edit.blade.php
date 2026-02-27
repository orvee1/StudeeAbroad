@extends('student.layouts.app')

@section('page_title', 'Edit Success Story')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <div class="text-sm text-slate-500">Student Portal</div>
                <div class="text-xl font-semibold text-slate-900">Edit Success Story</div>
            </div>
            <a href="{{ route('student.success_stories.index') }}"
                class="px-4 py-2 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50">
                Back
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                <div class="font-semibold">Please fix the errors:</div>
                <ul class="list-disc pl-5 text-sm mt-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-start justify-between gap-3">
                <div>
                    <div class="text-sm text-slate-600">Update your story details</div>
                    <div class="text-xs text-slate-500 mt-1">
                        Status:
                        <span class="font-semibold {{ $story->is_active ? 'text-emerald-700' : 'text-amber-700' }}">
                            {{ $story->is_active ? 'Approved' : 'Pending' }}
                        </span>
                        (After editing, admin approval may be required again)
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('student.success_stories.update', $story) }}"
                enctype="multipart/form-data" class="p-5 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Name <span class="text-rose-500">*</span></label>
                        <input name="name" value="{{ old('name', $story->name) }}"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">From (City, Country)</label>
                        <input name="from" value="{{ old('from', $story->from) }}"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Destination (Country • University)</label>
                        <input name="destination" value="{{ old('destination', $story->destination) }}"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium">Badge</label>
                        <select name="badge"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">
                            <option value="">Select</option>
                            @foreach (['Admitted', 'Offer Received', 'Visa Approved'] as $b)
                                <option value="{{ $b }}" @selected(old('badge', $story->badge) === $b)>{{ $b }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Score</label>
                        <input name="score" value="{{ old('score', $story->score) }}"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Year</label>
                        <input name="year" value="{{ old('year', $story->year) }}"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">Your Story <span class="text-rose-500">*</span></label>
                    <textarea name="story" rows="6"
                        class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">{{ old('story', $story->story) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Replace Photo (optional)</label>
                        <input type="file" name="photo" class="mt-1 block w-full text-sm" />
                        <div class="text-xs text-slate-500 mt-1">JPG/PNG/WEBP (max 2MB)</div>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Current Photo</label>
                        <div class="mt-1 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            @if ($story->photo_path)
                                <img src="{{ asset('storage/' . $story->photo_path) }}"
                                    class="h-20 w-20 rounded-2xl object-cover border border-slate-200" alt="">
                            @else
                                <div class="text-sm text-slate-500">No photo</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Update Story
                    </button>
                    <a href="{{ route('student.success_stories.index') }}"
                        class="px-5 py-3 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            Editing may require admin re-approval before it becomes visible on the public website.
        </div>
    </div>
@endsection
