<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        ]);

        $query = Lead::query()->with(['desiredCountry:id,name', 'desiredUniversity:id,name']);
        if (! empty($filters['q'])) {
            $term = trim($filters['q']);
            $query->where(fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%")->orWhere('phone', 'like', "%{$term}%"));
        }
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $leads = $query->latest()->paginate(20)->appends($request->query());
        $statusCounts = Lead::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $statuses = self::STATUSES;

        return view('admin.leads.index', compact('leads', 'filters', 'statusCounts', 'statuses'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate(['status' => ['required', 'in:' . implode(',', self::STATUSES)]]);
        $lead->update($data);

        return back()->with('success', 'Enquiry status updated.');
    }
}
