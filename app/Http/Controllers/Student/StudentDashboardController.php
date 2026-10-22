<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lead;
use App\Models\University;

class StudentDashboardController extends Controller
{
    public function __invoke()
    {
        $featuredUniversities = University::query()
            ->with(['country:id,name', 'state:id,name', 'city:id,name'])
            ->withCount(['programs' => fn ($programs) => $programs->where('is_active', true)])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(8)
            ->get();

        $topCountries = Country::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(8)
            ->get(['id', 'name', 'slug', 'flag_path']);

        $quickStats = [
            'featured_universities' => $featuredUniversities->count(),
            'countries'             => Country::query()->where('is_active', true)->count(),
            'universities'          => University::query()->where('is_active', true)->count(),
            'enquiries'             => Lead::query()->whereRaw('LOWER(email) = ?', [mb_strtolower(auth()->user()->email)])->count(),
        ];

        $latestEnquiries = Lead::query()
            ->whereRaw('LOWER(email) = ?', [mb_strtolower(auth()->user()->email)])
            ->with(['desiredCountry:id,name', 'desiredUniversity:id,name'])
            ->latest()
            ->take(3)
            ->get();

        return view('student.dashboard', compact('featuredUniversities', 'topCountries', 'quickStats', 'latestEnquiries'));
    }
}
