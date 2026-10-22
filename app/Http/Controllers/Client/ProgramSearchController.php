<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\UniversityProgram;
use Illuminate\Http\Request;

class ProgramSearchController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'level' => ['nullable', 'string', 'max:40'],
            'field' => ['nullable', 'string', 'max:100'],
            'intake' => ['nullable', 'string', 'max:20'],
            'tuition_min' => ['nullable', 'integer', 'min:0'],
            'tuition_max' => ['nullable', 'integer', 'min:0'],
            'sort' => ['nullable', 'in:relevance,tuition_low,tuition_high'],
            'per_page' => ['nullable', 'integer', 'min:6', 'max:48'],
        ]);

        $query = UniversityProgram::query()
            ->where('is_active', true)
            ->whereHas('university', function ($university) use ($filters) {
                $university->where('is_active', true);
                if (! empty($filters['country_id'])) {
                    $university->where('country_id', $filters['country_id']);
                }
            })
            ->with(['university.country:id,name,slug,currency', 'university.state:id,name', 'university.city:id,name']);

        if (! empty($filters['q'])) {
            $term = trim($filters['q']);
            $query->where(function ($program) use ($term) {
                $program->where('title', 'like', "%{$term}%")
                    ->orWhere('field', 'like', "%{$term}%")
                    ->orWhereHas('university', fn ($university) => $university->where('name', 'like', "%{$term}%"));
            });
        }

        foreach (['level', 'field'] as $column) {
            if (! empty($filters[$column])) {
                $query->where($column, $filters[$column]);
            }
        }

        if (! empty($filters['intake'])) {
            $query->whereJsonContains('intake_months', $filters['intake']);
        }

        if (isset($filters['tuition_min'])) {
            $query->whereRaw(
                'COALESCE(tuition_per_year_max, tuition_per_semester_max * semesters_per_year, 999999999) >= ?',
                [$filters['tuition_min']]
            );
        }
        if (isset($filters['tuition_max'])) {
            $query->whereRaw(
                'COALESCE(tuition_per_year_min, tuition_per_semester_min * semesters_per_year, 0) <= ?',
                [$filters['tuition_max']]
            );
        }

        $sort = $filters['sort'] ?? 'relevance';
        if ($sort === 'tuition_low') {
            $query->orderByRaw('COALESCE(tuition_per_year_min, tuition_per_semester_min * semesters_per_year, tuition_per_year_max, tuition_per_semester_max * semesters_per_year, 999999999) asc');
        } elseif ($sort === 'tuition_high') {
            $query->orderByRaw('COALESCE(tuition_per_year_max, tuition_per_semester_max * semesters_per_year, tuition_per_year_min, tuition_per_semester_min * semesters_per_year, 0) desc');
        } else {
            $query->orderBy('sort_order')->orderBy('title');
        }

        $programs = $query->paginate((int) ($filters['per_page'] ?? 12))->appends($request->query());
        $countries = Country::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        $levels = UniversityProgram::query()->where('is_active', true)->whereNotNull('level')->distinct()->orderBy('level')->pluck('level');
        $fields = UniversityProgram::query()->where('is_active', true)->whereNotNull('field')->where('field', '<>', '')->distinct()->orderBy('field')->pluck('field');
        $intakes = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('client.programs.index', compact('programs', 'countries', 'levels', 'fields', 'intakes', 'filters'));
    }
}
