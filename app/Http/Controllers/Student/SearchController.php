<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'country_id'  => ['nullable', 'integer'],
            'state_id'    => ['nullable', 'integer'],
            'city_id'     => ['nullable', 'integer'],
            'q'           => ['nullable', 'string', 'max:120'],
            'tuition_min' => ['nullable', 'integer', 'min:0'],
            'tuition_max' => ['nullable', 'integer', 'min:0'],
            'intake'      => ['nullable', 'string', 'max:20'], // e.g. January
            'level'       => ['nullable', 'string', 'max:40'], // Bachelor/Master etc
            'sort'        => ['nullable', 'string', 'in:relevance,tuition_low,tuition_high,ranking'],
            'per_page'    => ['nullable', 'integer', 'min:6', 'max:48'],
        ]);

        $perPage = (int) ($filters['per_page'] ?? 12);

        $query = University::query()
            ->where('is_active', true);

        // Location filters
        if (! empty($filters['country_id'])) {
            $query->where('country_id', $filters['country_id']);
        }

        if (! empty($filters['state_id'])) {
            $query->where('state_id', $filters['state_id']);
        }

        if (! empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }

        // Keyword search
        if (! empty($filters['q'])) {
            $q = trim($filters['q']);
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        // Tuition filters (works even if nulls)
        if (isset($filters['tuition_min'])) {
            $query->where(function ($qq) use ($filters) {
                $min = (int) $filters['tuition_min'];
                $qq->whereNull('tuition_min')->orWhere('tuition_min', '>=', $min)->orWhere('tuition_max', '>=', $min);
            });
        }
        if (isset($filters['tuition_max'])) {
            $query->where(function ($qq) use ($filters) {
                $max = (int) $filters['tuition_max'];
                $qq->whereNull('tuition_max')->orWhere('tuition_max', '<=', $max)->orWhere('tuition_min', '<=', $max);
            });
        }

        // Program-based filters
        // Requires University -> programs() relationship
        if (! empty($filters['intake']) || ! empty($filters['level'])) {
            $query->whereHas('programs', function ($p) use ($filters) {
                $p->where('is_active', true);

                if (! empty($filters['level'])) {
                    $p->where('level', $filters['level']);
                }

                if (! empty($filters['intake'])) {
                    // intake_months is JSON. Use whereJsonContains.
                    $p->whereJsonContains('intake_months', $filters['intake']);
                }
            });
        }

        // Sorting
        $sort = $filters['sort'] ?? 'relevance';
        if ($sort === 'tuition_low') {
            $query->orderByRaw('COALESCE(tuition_min, tuition_max, 999999999) asc');
        } elseif ($sort === 'tuition_high') {
            $query->orderByRaw('COALESCE(tuition_max, tuition_min, 0) desc');
        } elseif ($sort === 'ranking') {
            $query->orderByRaw('COALESCE(world_ranking, 999999999) asc');
        } else {
            // relevance fallback
            $query->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name');
        }

        $universities = $query->paginate($perPage)
            ->appends(request()->query());

        // For dropdowns
        $countries = Country::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        $states    = collect();
        $cities    = collect();

        if (! empty($filters['country_id'])) {
            $states = State::where('is_active', true)->where('country_id', $filters['country_id'])->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        }
        if (! empty($filters['state_id'])) {
            $cities = City::where('is_active', true)->where('state_id', $filters['state_id'])->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        }

        // Filter presets
        $levels  = ['Bachelor', 'Master', 'PhD', 'Diploma'];
        $intakes = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('client.search', compact(
            'universities',
            'countries',
            'states',
            'cities',
            'levels',
            'intakes',
            'filters'
        ));
    }

    public function states(Request $request)
    {
        $countryId = (int) $request->get('country_id', 0);

        $states = State::query()
            ->where('is_active', true)
            ->when($countryId > 0, fn($q) => $q->where('country_id', $countryId))
            ->orderBy('sort_order')->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($states);
    }

    public function cities(Request $request)
    {
        $stateId = (int) $request->get('state_id', 0);

        $cities = City::query()
            ->where('is_active', true)
            ->when($stateId > 0, fn($q) => $q->where('state_id', $stateId))
            ->orderBy('sort_order')->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }
}
