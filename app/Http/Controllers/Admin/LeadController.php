<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private const STATUSES = ['new', 'contacted', 'qualified', 'closed'];

    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:new,contacted,qualified,closed'],
            'date_from' => ['nullable', 'date'],
            'date_to' => $request->filled('date_from')
                ? ['nullable', 'date', 'after_or_equal:date_from']
                : ['nullable', 'date'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'programme' => ['nullable', 'string', 'max:40'],
        ]);

        $query = Lead::query()->with(['desiredCountry:id,name', 'desiredUniversity:id,name']);
        if (! empty($filters['q'])) {
            $term = trim($filters['q']);
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%")->orWhere('phone', 'like', "%{$term}%"));
        }
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        if (! empty($filters['country_id'])) {
            $query->where('desired_country_id', $filters['country_id']);
        }
        if (! empty($filters['programme'])) {
            $query->where('desired_level', $filters['programme']);
        }

        $leads = $query->latest()->paginate(20)->appends($request->query());
        $statusCounts = Lead::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $statuses = self::STATUSES;
        $countries = Country::query()->orderBy('name')->get(['id', 'name']);
        $programmes = collect(['Bachelor', 'Master', 'PhD', 'Diploma'])
            ->merge(Lead::query()->whereNotNull('desired_level')->where('desired_level', '<>', '')->distinct()->orderBy('desired_level')->pluck('desired_level'))
            ->unique()
            ->values();

        return view('admin.leads.index', compact('leads', 'filters', 'statusCounts', 'statuses', 'countries', 'programmes'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate(['status' => ['required', 'in:' . implode(',', self::STATUSES)]]);
        $lead->update($data);

        return back()->with('success', 'Enquiry status updated.');
    }
}
