<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\University;
use App\Models\UniversityProgram;

class PublicCatalogController extends Controller
{
    public function country(Country $country)
    {
        abort_unless($country->is_active, 404);

        $country->loadCount(['universities' => fn ($query) => $query->where('is_active', true)]);

        $universities = University::query()
            ->where('is_active', true)
            ->where('country_id', $country->id)
            ->with(['country:id,name,slug', 'state:id,name', 'city:id,name'])
            ->withCount(['programs' => fn ($query) => $query->where('is_active', true)])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        $stats = [
            'universities' => $country->universities_count,
            'cities' => City::query()->where('is_active', true)->whereHas('state', fn ($query) => $query->where('country_id', $country->id))->count(),
            'programs' => UniversityProgram::query()->where('is_active', true)->whereHas('university', fn ($query) => $query->where('is_active', true)->where('country_id', $country->id))->count(),
        ];

        return view('client.destinations.show', compact('country', 'universities', 'stats'));
    }

    public function university(University $university)
    {
        abort_unless($university->is_active, 404);

        $university->load([
            'country:id,name,slug,currency,description',
            'state:id,name',
            'city:id,name',
            'media' => fn ($query) => $query->where('is_active', true)->where('type', 'image')->orderBy('sort_order'),
        ]);

        $programs = $university->programs()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('level')
            ->orderBy('title')
            ->paginate(9);

        $relatedUniversities = University::query()
            ->where('is_active', true)
            ->where('country_id', $university->country_id)
            ->whereKeyNot($university->id)
            ->with(['country:id,name,slug', 'city:id,name'])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('client.universities.show', compact('university', 'programs', 'relatedUniversities'));
    }

    public function program(University $university, UniversityProgram $program)
    {
        abort_unless($university->is_active && $program->is_active, 404);

        $university->load(['country:id,name,slug,currency', 'state:id,name', 'city:id,name']);
        $relatedPrograms = $university->programs()
            ->where('is_active', true)
            ->whereKeyNot($program->id)
            ->when($program->field, fn ($query) => $query->where('field', $program->field))
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('client.programs.show', compact('university', 'program', 'relatedPrograms'));
    }
}
