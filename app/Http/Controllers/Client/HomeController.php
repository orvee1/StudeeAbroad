<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\SuccessStory;
use App\Models\University;
use App\Models\UniversityProgram;

class HomeController extends Controller
{
    public function __invoke()
    {
        $countries = Country::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        $topCountries = Country::query()
            ->where('is_active', true)
            ->withCount([
                'universities' => function ($q) {
                    $q->where('is_active', true);
                },
            ])
            ->orderByDesc('universities_count')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(8)
            ->get(['id', 'name', 'slug', 'flag_path']);

        $featuredUniversities = University::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with(['country:id,name', 'state:id,name', 'city:id,name'])
            ->withCount(['programs' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(8)
            ->get();

        $successStories = SuccessStory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $stats = [
            'countries'    => Country::where('is_active', true)->count(),
            'universities' => University::where('is_active', true)->count(),
            'programs'     => UniversityProgram::where('is_active', true)->count(),
            'support'      => '1:1',
        ];

        return view('client.home', compact(
            'countries',
            'topCountries',
            'featuredUniversities',
            'successStories',
            'stats'
        ));
    }
}
