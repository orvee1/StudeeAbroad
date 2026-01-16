<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StateStoreRequest;
use App\Http\Requests\Admin\StateUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $q         = trim((string) $request->get('q', ''));
        $countryId = $request->get('country_id');
        $isActive  = $request->get('is_active');

        $query = State::query()->with(['country:id,name']);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        if ($countryId !== null && $countryId !== '') {
            $query->where('country_id', (int) $countryId);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $states = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $countries = Country::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return view('admin.states.index', compact('states', 'countries', 'q', 'countryId', 'isActive'));
    }

    public function create()
    {
        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();
        return view('admin.states.create', compact('countries'));
    }

    public function store(StateStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug']       = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        State::create($data);

        return redirect()
            ->route('states.index')
            ->with('success', 'State created successfully.');
    }

    public function show(State $state)
    {
        $state->load(['country:id,name']);

        $citiesCount       = City::where('state_id', $state->id)->count();
        $universitiesCount = University::where('state_id', $state->id)->count();

        $topCities = City::query()
            ->where('state_id', $state->id)
            ->select(['id', 'name', 'slug', 'is_active'])
            ->orderBy('name')
            ->limit(12)
            ->get();

        $latestUniversities = University::query()
            ->where('state_id', $state->id)
            ->select(['id', 'name', 'slug', 'is_active', 'is_featured', 'logo_path'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return view('admin.states.show', compact(
            'state',
            'citiesCount',
            'universitiesCount',
            'topCities',
            'latestUniversities'
        ));
    }

    public function edit(State $state)
    {
        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();
        return view('admin.states.edit', compact('state', 'countries'));
    }

    public function update(StateUpdateRequest $request, State $state)
    {
        $data = $request->validated();

        $data['slug']       = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $state->update($data);

        return redirect()
            ->route('states.index')
            ->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        $state->delete();

        return redirect()
            ->route('states.index')
            ->with('success', 'State deleted successfully.');
    }
}
