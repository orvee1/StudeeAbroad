@extends('student.layouts.app')

@section('page_title', 'Add Success Story')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <div class="text-sm text-slate-500">Student Portal</div>
                <div class="text-xl font-semibold text-slate-900">Add Success Story</div>
            </div>
            <a href="{{ route('student.success_stories.index') }}"
                class="px-4 py-2 rounded-2xl border border-slate-200 bg-cyan-600 text-white text-sm hover:bg-blue-700">
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
            <div class="p-5 border-b border-slate-200">
                <div class="text-sm text-slate-600">Fill in your story details</div>
            </div>

            <form method="POST" action="{{ route('student.success_stories.store') }}" enctype="multipart/form-data"
                class="p-5 space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Name <span class="text-rose-500">*</span></label>
                        <input name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">From (City, Country)</label>
                        <input name="from" value="{{ old('from') }}" placeholder="Dhaka, Bangladesh"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Destination (Country • University)</label>
                        <input name="destination" value="{{ old('destination') }}"
                            placeholder="Canada • University of Toronto"
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
                                <option value="{{ $b }}" @selected(old('badge') === $b)>{{ $b }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Score</label>
                        <input name="score" value="{{ old('score') }}" placeholder="IELTS 7.0"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Year</label>
                        <input name="year" value="{{ old('year') }}" placeholder="2025"
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200" />
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">Your Story <span class="text-rose-500">*</span></label>
                    <textarea name="story" rows="6" placeholder="Write your success story..."
                        class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-400 focus:ring-indigo-200">{{ old('story') }}</textarea>
                    <div class="text-xs text-slate-500 mt-1">Tip: Keep it short and inspiring. This will show on the home
                        page after approval.</div>
                </div>

                <div>
                    <label class="text-sm font-medium">Photo (optional)</label>
                    <input type="file" name="photo" class="mt-1 block w-full text-sm" />
                    <div class="text-xs text-slate-500 mt-1">JPG/PNG/WEBP (max 2MB)</div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button class="px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Submit Story
                    </button>
                    <a href="{{ route('student.success_stories.index') }}"
                        class="px-5 py-3 rounded-2xl border border-slate-200 bg-white text-sm hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
            After you submit, the admin will review and approve your story before it becomes visible publicly.
        </div>
    </div>
@endsection
