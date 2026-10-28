@extends('admin.layouts.app')

@section('page_title', 'Student enquiries')
@section('breadcrumb', 'Admin / Enquiries')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Student interest</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-900">Enquiries</h1>
            <p class="mt-2 text-sm text-slate-600">Review student requests for guidance and update their follow-up status.</p>
        </div>

        @if (session('success'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach (['new' => 'New', 'contacted' => 'Contacted', 'qualified' => 'Qualified', 'closed' => 'Closed'] as $key => $label)
                <div class="rounded-2xl border border-slate-200 bg-white p-4"><p class="text-xs text-slate-500">{{ $label }}</p><p class="mt-1 text-2xl font-bold">{{ number_format($statusCounts[$key] ?? 0) }}</p></div>
            @endforeach
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <form method="GET" action="{{ route('leads.index') }}" class="grid gap-3 border-b border-slate-200 p-4 sm:grid-cols-2 lg:grid-cols-4 sm:items-end sm:p-5">
                <div class="lg:col-span-2"><label for="lead-q" class="text-xs font-semibold text-slate-600">Search name, email or phone</label><input id="lead-q" name="q" value="{{ $filters['q'] ?? '' }}" class="mt-1 w-full rounded-xl border-slate-300 text-sm"></div>
                <div><label for="lead-status" class="text-xs font-semibold text-slate-600">Status</label><select id="lead-status" name="status" class="mt-1 w-full rounded-xl border-slate-300 text-sm"><option value="">All statuses</option>@foreach($statuses as $status)<option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>@endforeach</select></div>
                <div><label for="lead-country" class="text-xs font-semibold text-slate-600">Country</label><select id="lead-country" name="country_id" class="mt-1 w-full rounded-xl border-slate-300 text-sm"><option value="">All countries</option>@foreach($countries as $country)<option value="{{ $country->id }}" @selected((string) ($filters['country_id'] ?? '') === (string) $country->id)>{{ $country->name }}</option>@endforeach</select></div>
                <div><label for="lead-programme" class="text-xs font-semibold text-slate-600">Programme / study level</label><select id="lead-programme" name="programme" class="mt-1 w-full rounded-xl border-slate-300 text-sm"><option value="">All programmes</option>@foreach($programmes as $programme)<option value="{{ $programme }}" @selected(($filters['programme'] ?? '') === $programme)>{{ $programme }}</option>@endforeach</select></div>
                <div><label for="lead-date-from" class="text-xs font-semibold text-slate-600">Received from</label><input id="lead-date-from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="mt-1 w-full rounded-xl border-slate-300 text-sm">@error('date_from')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="lead-date-to" class="text-xs font-semibold text-slate-600">Received to</label><input id="lead-date-to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="mt-1 w-full rounded-xl border-slate-300 text-sm">@error('date_to')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div class="flex gap-2 sm:col-span-2 lg:col-span-4 lg:justify-end"><button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white">Apply filters</button><a href="{{ route('leads.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-center text-sm font-semibold text-slate-700">Reset</a></div>
            </form>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-3">Student</th><th class="px-5 py-3">Interested in</th><th class="px-5 py-3">Request</th><th class="px-5 py-3">Received</th><th class="px-5 py-3">Status</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($leads as $lead)
                            <tr class="align-top">
                                <td class="px-5 py-4"><p class="font-semibold text-slate-900">{{ $lead->name }}</p><a href="mailto:{{ $lead->email }}" class="text-xs text-indigo-700">{{ $lead->email }}</a>@if($lead->phone)<a href="tel:{{ $lead->phone }}" class="mt-1 block text-xs text-slate-500">{{ $lead->phone }}</a>@endif</td>
                                <td class="px-5 py-4"><p>{{ $lead->desiredUniversity?->name ?: 'University guidance' }}</p><p class="mt-1 text-xs text-slate-500">{{ $lead->desiredCountry?->name }} @if($lead->desired_level)· {{ $lead->desired_level }}@endif @if($lead->preferred_intake)· {{ $lead->preferred_intake }}@endif</p></td>
                                <td class="max-w-xs px-5 py-4"><p class="line-clamp-3 text-slate-600">{{ $lead->message ?: 'No additional message.' }}</p><p class="mt-1 text-[11px] text-slate-400">Source: {{ $lead->source ?: '—' }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">{{ $lead->created_at?->format('d M Y, H:i') }}</td>
                                <td class="min-w-40 px-5 py-4"><form method="POST" action="{{ route('leads.update', $lead) }}" class="flex items-center gap-2">@csrf @method('PATCH')<label for="lead-status-{{ $lead->id }}" class="sr-only">Status for {{ $lead->name }}</label><select id="lead-status-{{ $lead->id }}" name="status" class="min-w-28 rounded-lg border-slate-300 text-xs">@foreach($statuses as $status)<option value="{{ $status }}" @selected($lead->status === $status)>{{ ucfirst($status) }}</option>@endforeach</select><button class="rounded-lg border border-slate-300 px-2.5 py-2 text-xs font-semibold hover:bg-slate-50">Save</button></form></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center"><p class="font-semibold text-slate-800">No enquiries found</p><p class="mt-1 text-sm text-slate-500">New student enquiries will appear here.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 p-4">{{ $leads->links() }}</div>
        </div>
    </div>
@endsection
