<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UniversityMediaController;
use App\Http\Controllers\Admin\UniversityProgramController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
    // Dependent API for state dropdown (country -> states)
    Route::get('api/states-by-country', [CityController::class, 'statesByCountry'])->name('api.statesByCountry');

    // University Routes
    Route::get('universities', [UniversityController::class, 'index'])->name('universities.index');
    Route::get('universities/create', [UniversityController::class, 'create'])->name('universities.create');
    Route::post('universities', [UniversityController::class, 'store'])->name('universities.store');
    Route::get('universities/{university}', [UniversityController::class, 'show'])->name('universities.show');
    Route::get('universities/{university}/edit', [UniversityController::class, 'edit'])->name('universities.edit');
    Route::put('universities/{university}', [UniversityController::class, 'update'])->name('universities.update');
    Route::delete('universities/{university}', [UniversityController::class, 'destroy'])->name('universities.destroy');
    // Dependent API (state -> cities)
    Route::get('api/cities-by-state', [UniversityController::class, 'citiesByState'])->name('api.citiesByState');

    // University Programs Routes
    Route::get('universities/{university}/programs', [UniversityProgramController::class, 'index'])->name('universities.programs.index');
    Route::get('universities/{university}/programs/create', [UniversityProgramController::class, 'create'])->name('universities.programs.create');
    Route::post('universities/{university}/programs', [UniversityProgramController::class, 'store'])->name('universities.programs.store');
    Route::get('universities/{university}/programs/{program}/edit', [UniversityProgramController::class, 'edit'])->name('universities.programs.edit');
    Route::put('universities/{university}/programs/{program}', [UniversityProgramController::class, 'update'])->name('universities.programs.update');
    Route::delete('universities/{university}/programs/{program}', [UniversityProgramController::class, 'destroy'])->name('universities.programs.destroy');

    // University Media Routes
    Route::get('universities/{university}/media', [UniversityMediaController::class, 'index'])->name('universities.media.index');
    Route::get('universities/{university}/media/create', [UniversityMediaController::class, 'create'])->name('universities.media.create');
    Route::post('universities/{university}/media', [UniversityMediaController::class, 'store'])->name('universities.media.store');
    Route::get('universities/{university}/media/{media}/edit', [UniversityMediaController::class, 'edit'])->name('universities.media.edit');
    Route::put('universities/{university}/media/{media}', [UniversityMediaController::class, 'update'])->name('universities.media.update');
    Route::delete('universities/{university}/media/{media}', [UniversityMediaController::class, 'destroy'])->name('universities.media.destroy');
});

require __DIR__ . '/auth.php';
