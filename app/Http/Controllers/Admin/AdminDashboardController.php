<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use App\Models\UniversityMedia;
use App\Models\UniversityProgram;
use App\Models\User;

class AdminDashboardController extends Controller
{

    public function __invoke()
    {
        $stats = [
            'countries'    => Country::count(),
            'states'       => State::count(),
            'cities'       => City::count(),
            'universities' => University::count(),
            'programs'     => UniversityProgram::count(),
            'media'        => UniversityMedia::count(),
            'students'     => User::query()->where('role', 'student')->count(),
        ];

        $latestStudents = User::query()
            ->where('role', 'student')
            ->latest()
            ->take(6)
            ->get(['id', 'name', 'email', 'phone', 'created_at', 'is_active']);

        $featuredUniversities = University::query()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(6)
            ->get(['id', 'name', 'slug', 'logo_path', 'country_id', 'state_id', 'city_id']);

        return view('admin.dashboard', compact('stats', 'latestStudents', 'featuredUniversities'));
    }
}
