<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UniversityStoreRequest;
use App\Http\Requests\Admin\UniversityUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        $q         = trim((string) $request->get('q', ''));
        $countryId = $request->get('country_id');
        $stateId   = $request->get('state_id');
        $cityId    = $request->get('city_id');

        $isActive   = $request->get('is_active');
        $isFeatured = $request->get('is_featured');

        $query = University::query()->with([
            'country:id,name',
            'state:id,name,country_id',
            'city:id,name,state_id',
        ]);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('website_url', 'like', "%{$q}%");
            });
        }

        if ($cityId !== null && $cityId !== '') {
            $query->where('city_id', (int) $cityId);
        } elseif ($stateId !== null && $stateId !== '') {
            $query->where('state_id', (int) $stateId);
        } elseif ($countryId !== null && $countryId !== '') {
            $query->where('country_id', (int) $countryId);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }
        if ($isFeatured !== null && $isFeatured !== '') {
            $query->where('is_featured', (bool) $isFeatured);
        }

        $universities = $query
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

        $cities = City::query()
            ->select(['id', 'state_id', 'name'])
            ->when($stateId, fn($c) => $c->where('state_id', (int) $stateId))
            ->orderBy('name')
            ->get();

        return view('admin.universities.index', compact(
            'universities',
            'countries', 'states', 'cities',
            'q', 'countryId', 'stateId', 'cityId',
            'isActive', 'isFeatured'
        ));
    }

    public function create(Request $request)
    {
        $countryId = $request->get('country_id');
        $stateId   = $request->get('state_id');
        $cityId    = $request->get('city_id');

        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();

        $states = State::query()
            ->select(['id', 'country_id', 'name'])
            ->when($countryId, fn($s) => $s->where('country_id', (int) $countryId))
            ->orderBy('name')
            ->get();

        $cities = City::query()
            ->select(['id', 'state_id', 'name'])
            ->when($stateId, fn($c) => $c->where('state_id', (int) $stateId))
            ->orderBy('name')
            ->get();

        return view('admin.universities.create', compact(
            'countries', 'states', 'cities',
            'countryId', 'stateId', 'cityId'
        ));
    }

    public function store(UniversityStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        $data['scholarship_available'] = (bool) ($data['scholarship_available'] ?? false);
        $data['is_featured']           = (bool) ($data['is_featured'] ?? false);
        $data['is_active']             = (bool) ($data['is_active'] ?? false);
        $data['sort_order']            = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('universities/logos', 'public');
        }
        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('universities/covers', 'public');
        }

        University::create($data);

        return redirect()
            ->route('universities.index')
            ->with('success', 'University created successfully.');
    }

    public function show(University $university)
    {
        $university->load(['country:id,name', 'state:id,name', 'city:id,name']);

        return view('admin.universities.show', compact('university'));
    }

    public function edit(University $university)
    {
        $countries = Country::query()->select(['id', 'name'])->orderBy('name')->get();

        $states = State::query()
            ->select(['id', 'country_id', 'name'])
            ->where('country_id', (int) $university->country_id)
            ->orderBy('name')
            ->get();

        $cities = City::query()
            ->select(['id', 'state_id', 'name'])
            ->where('state_id', (int) $university->state_id)
            ->orderBy('name')
            ->get();

        return view('admin.universities.edit', compact('university', 'countries', 'states', 'cities'));
    }

    public function update(UniversityUpdateRequest $request, University $university)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        $data['scholarship_available'] = (bool) ($data['scholarship_available'] ?? false);
        $data['is_featured']           = (bool) ($data['is_featured'] ?? false);
        $data['is_active']             = (bool) ($data['is_active'] ?? false);
        $data['sort_order']            = (int) ($data['sort_order'] ?? 0);

        if ($request->hasFile('logo')) {
            if ($university->logo_path && Storage::disk('public')->exists($university->logo_path)) {
                Storage::disk('public')->delete($university->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('universities/logos', 'public');
        }

        if ($request->hasFile('cover')) {
            if ($university->cover_path && Storage::disk('public')->exists($university->cover_path)) {
                Storage::disk('public')->delete($university->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('universities/covers', 'public');
        }

        $university->update($data);

        return redirect()
            ->route('universities.index')
            ->with('success', 'University updated successfully.');
    }

    public function destroy(University $university)
    {
        // optional: delete files on delete? (soft delete so keep files)
        $university->delete();

        return redirect()
            ->route('universities.index')
            ->with('success', 'University deleted successfully.');
    }

    /**
     * ✅ Dependent dropdown: cities by state
     */
    public function citiesByState(Request $request)
    {
        $stateId = (int) $request->get('state_id');

        $cities = City::query()
            ->select(['id', 'name'])
            ->where('state_id', $stateId)
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }
}
