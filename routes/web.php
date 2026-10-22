<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SuccessStoryController as AdminSuccessStoryController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UniversityMediaController;
use App\Http\Controllers\Admin\UniversityProgramController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\LeadController;
use App\Http\Controllers\Client\ProgramSearchController;
use App\Http\Controllers\Client\PublicCatalogController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\SearchController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\SuccessStoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/destinations/{country:slug}', [PublicCatalogController::class, 'country'])->name('public.destinations.show');
Route::get('/universities/{university:slug}', [PublicCatalogController::class, 'university'])->name('public.universities.show');
Route::get('/universities/{university:slug}/programs/{program:slug}', [PublicCatalogController::class, 'program'])
    ->scopeBindings()
    ->name('public.programs.show');
Route::get('/programs', [ProgramSearchController::class, 'index'])->name('public.programs.index');
Route::post('/enquiries', [LeadController::class, 'store'])->middleware('throttle:5,1')->name('enquiries.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    Route::get('/student/dashboard', StudentDashboardController::class)->name('student.dashboard');
    Route::get('/student/enquiries', [\App\Http\Controllers\Student\EnquiryController::class, 'index'])->name('student.enquiries.index');
    Route::get('/student/success-stories', [SuccessStoryController::class, 'index'])->name('student.success_stories.index');
    Route::get('/student/success-stories/create', [SuccessStoryController::class, 'create'])->name('student.success_stories.create');
    Route::post('/student/success-stories', [SuccessStoryController::class, 'store'])->name('student.success_stories.store');
    Route::get('/student/success-stories/{success_story}/edit', [SuccessStoryController::class, 'edit'])->name('student.success_stories.edit');
    Route::put('/student/success-stories/{success_story}', [SuccessStoryController::class, 'update'])->name('student.success_stories.update');
});

// Admin Login (separate URL)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('admin.home');

    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
    Route::patch('/leads/{lead}', [AdminLeadController::class, 'update'])->name('leads.update');

    // Students
    Route::get('students', [StudentController::class, 'index'])->name('students.index');

    // Country Routes
    Route::get('countries', [CountryController::class, 'index'])->name('countries.index');
    Route::get('countries/create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('countries', [CountryController::class, 'store'])->name('countries.store');
    Route::get('countries/{country}', [CountryController::class, 'show'])->name('countries.show');
    Route::get('countries/{country}/edit', [CountryController::class, 'edit'])->name('countries.edit');
    Route::put('countries/{country}', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('countries/{country}', [CountryController::class, 'destroy'])->name('countries.destroy');

    // State Routes
    Route::get('states', [StateController::class, 'index'])->name('states.index');
    Route::get('states/create', [StateController::class, 'create'])->name('states.create');
    Route::post('states', [StateController::class, 'store'])->name('states.store');
    Route::get('states/{state}', [StateController::class, 'show'])->name('states.show');
    Route::get('states/{state}/edit', [StateController::class, 'edit'])->name('states.edit');
    Route::put('states/{state}', [StateController::class, 'update'])->name('states.update');
    Route::delete('states/{state}', [StateController::class, 'destroy'])->name('states.destroy');

    // City Routes
    Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('cities/{city}', [CityController::class, 'show'])->name('cities.show');
    Route::get('cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
    Route::get('api/states-by-country', [CityController::class, 'statesByCountry'])->name('api.statesByCountry');

    // University Routes
    Route::get('universities', [UniversityController::class, 'index'])->name('universities.index');
    Route::get('universities/create', [UniversityController::class, 'create'])->name('universities.create');
    Route::post('universities', [UniversityController::class, 'store'])->name('universities.store');
    Route::get('universities/{university}', [UniversityController::class, 'show'])->name('universities.show');
    Route::get('universities/{university}/edit', [UniversityController::class, 'edit'])->name('universities.edit');
    Route::put('universities/{university}', [UniversityController::class, 'update'])->name('universities.update');
    Route::patch('universities/{university}/featured', [UniversityController::class, 'toggleFeatured'])->name('universities.featured');
    Route::delete('universities/{university}', [UniversityController::class, 'destroy'])->name('universities.destroy');
    Route::get('api/cities-by-state', [UniversityController::class, 'citiesByState'])->name('api.citiesByState');

    // University Programs
    Route::get('universities/{university}/programs', [UniversityProgramController::class, 'index'])->name('universities.programs.index');
    Route::get('universities/{university}/programs/create', [UniversityProgramController::class, 'create'])->name('universities.programs.create');
    Route::post('universities/{university}/programs', [UniversityProgramController::class, 'store'])->name('universities.programs.store');
    Route::get('universities/{university}/programs/{program}/edit', [UniversityProgramController::class, 'edit'])->name('universities.programs.edit');
    Route::put('universities/{university}/programs/{program}', [UniversityProgramController::class, 'update'])->name('universities.programs.update');
    Route::delete('universities/{university}/programs/{program}', [UniversityProgramController::class, 'destroy'])->name('universities.programs.destroy');

    // University Media
    Route::get('universities/{university}/media', [UniversityMediaController::class, 'index'])->name('universities.media.index');
    Route::get('universities/{university}/media/create', [UniversityMediaController::class, 'create'])->name('universities.media.create');
    Route::post('universities/{university}/media', [UniversityMediaController::class, 'store'])->name('universities.media.store');
    Route::get('universities/{university}/media/{media}/edit', [UniversityMediaController::class, 'edit'])->name('universities.media.edit');
    Route::put('universities/{university}/media/{media}', [UniversityMediaController::class, 'update'])->name('universities.media.update');
    Route::delete('universities/{university}/media/{media}', [UniversityMediaController::class, 'destroy'])->name('universities.media.destroy');

    // Success Stories
    Route::get('success-stories', [AdminSuccessStoryController::class, 'index'])->name('success_stories.index');
    Route::put('success-stories/{success_story}', [AdminSuccessStoryController::class, 'update'])->name('success_stories.update');
    Route::delete('success-stories/{success_story}', [AdminSuccessStoryController::class, 'destroy'])->name('success_stories.destroy');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/states', [SearchController::class, 'states'])->name('api.states');
Route::get('/api/cities', [SearchController::class, 'cities'])->name('api.cities');

require __DIR__ . '/auth.php';
