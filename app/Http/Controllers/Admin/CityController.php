<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityStoreRequest;
use App\Http\Requests\Admin\CityUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $q         = trim((string) $request->get('q', ''));
        $countryId = $request->get('country_id');
        $stateId   = $request->get('state_id');
        $isActive  = $request->get('is_active');

        $query = City::query()
            ->with([
                'state:id,country_id,name',
                'state.country:id,name',
            ]);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            });
        }

        if ($stateId !== null && $stateId !== '') {
            $query->where('state_id', (int) $stateId);
        } elseif ($countryId !== null && $countryId !== '') {
            // filter by country through states
            $query->whereIn('state_id', function ($sq) use ($countryId) {
                $sq->select('id')->from('states')->where('country_id', (int) $countryId);
            });
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $cities = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();

        $states = State::query()
            ->select(['id', 'country_id', 'name'])
            ->when($countryId, fn($s) => $s->where('country_id', (int) $countryId))
            ->orderBy('name')
            ->get();

        return view('admin.cities.index', compact(
            'cities', 'countries', 'states', 'q', 'countryId', 'stateId', 'isActive'
        ));
    }

    public function create(Request $request)
    {
        $countryId = $request->get('country_id');
        $stateId   = $request->get('state_id');

        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();

        $states = State::query()
            ->select(['id', 'country_id', 'name'])
            ->when($countryId, fn($s) => $s->where('country_id', (int) $countryId))
            ->orderBy('name')
            ->get();

        return view('admin.cities.create', compact('countries', 'states', 'countryId', 'stateId'));
    }

    public function store(CityStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug']       = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        City::create($data);

        return redirect()
            ->route('cities.index')
            ->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        $city->load([
            'state:id,country_id,name',
            'state.country:id,name',
        ]);

        $universitiesCount = University::where('city_id', $city->id)->count();

        $latestUniversities = University::query()
            ->where('city_id', $city->id)
            ->select(['id', 'name', 'slug', 'is_active', 'is_featured', 'logo_path'])
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('admin.cities.show', compact('city', 'universitiesCount', 'latestUniversities'));
    }

    public function edit(City $city)
    {
        $city->load(['state:id,country_id,name', 'state.country:id,name']);

        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();

        $states = State::query()
            ->select(['id', 'country_id', 'name'])
            ->when($city->state?->country_id, fn($s) => $s->where('country_id', (int) $city->state->country_id))
            ->orderBy('name')
            ->get();

        return view('admin.cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(CityUpdateRequest $request, City $city)
    {
        $data = $request->validated();

        $data['slug']       = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $city->update($data);

        return redirect()
            ->route('cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()
            ->route('cities.index')
            ->with('success', 'City deleted successfully.');
    }

    /**
     * ✅ Dependent dropdown endpoint: states by country
     */
    public function statesByCountry(Request $request)
    {
        $countryId = (int) $request->get('country_id');

        $states = State::query()
            ->select(['id', 'name'])
            ->where('country_id', $countryId)
            ->orderBy('name')
            ->get();

        return response()->json($states);
    }
}
