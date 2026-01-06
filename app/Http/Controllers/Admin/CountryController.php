<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryStoreRequest;
use App\Http\Requests\Admin\CountryUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string) $request->get('q', ''));
        $isActive = $request->get('is_active');

        $query = Country::query();

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('iso2', 'like', "%{$q}%")
                    ->orWhere('iso3', 'like', "%{$q}%")
                    ->orWhere('currency', 'like', "%{$q}%")
                    ->orWhere('phone_code', 'like', "%{$q}%");
            });
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $countries = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.countries.index', compact('countries', 'q', 'isActive'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(CountryStoreRequest $request)
    {
        $data = $request->validated();

        // slug fallback (if you later want to make slug optional in UI)
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        // checkbox safe
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('flag')) {
            $data['flag_path'] = $request->file('flag')->store('countries/flags', 'public');
        }

        Country::create($data);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country created successfully.');
    }

    public function show(Country $country)
    {
        $statesCount = State::where('country_id', $country->id)->count();

        // cities are under states, so count via subquery
        $citiesCount = City::whereIn('state_id', function ($q) use ($country) {
            $q->select('id')->from('states')->where('country_id', $country->id);
        })->count();

        $universitiesCount = University::where('country_id', $country->id)->count();

        $topStates = State::query()
            ->where('country_id', $country->id)
            ->select(['id', 'name', 'slug', 'is_active'])
            ->withCount('cities')
            ->orderBy('name')
            ->limit(10)
            ->get();

        $latestUniversities = University::query()
            ->where('country_id', $country->id)
            ->select(['id', 'name', 'slug', 'city_id', 'state_id', 'is_active', 'is_featured', 'logo_path'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return view('admin.countries.show', compact(
            'country',
            'statesCount',
            'citiesCount',
            'universitiesCount',
            'topStates',
            'latestUniversities'
        ));
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(CountryUpdateRequest $request, Country $country)
    {
        $data = $request->validated();

        $data['slug']       = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active']  = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('flag')) {
            if ($country->flag_path && Storage::disk('public')->exists($country->flag_path)) {
                Storage::disk('public')->delete($country->flag_path);
            }
            $data['flag_path'] = $request->file('flag')->store('countries/flags', 'public');
        }

        $country->update($data);

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('admin.countries.index')
            ->with('success', 'Country moved to trash.');
    }
}
