<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UniversityProgramStoreRequest;
use App\Http\Requests\Admin\UniversityProgramUpdateRequest;
use App\Models\University;
use App\Models\UniversityProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UniversityProgramController extends Controller
{
    public function index(University $university, Request $request)
    {
        $q        = trim((string) $request->get('q', ''));
        $isActive = $request->get('is_active');
        $level    = $request->get('level');

        $query = UniversityProgram::query()
            ->where('university_id', $university->id);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('field', 'like', "%{$q}%");
            });
        }

        if ($level !== null && $level !== '') {
            $query->where('level', $level);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where('is_active', (bool) $isActive);
        }

        $programs = $query->orderBy('sort_order')->orderBy('title')->paginate(20)->withQueryString();

        // distinct levels for filter
        $levels = UniversityProgram::query()
            ->where('university_id', $university->id)
            ->select('level')->distinct()->orderBy('level')->pluck('level');

        return view('admin.universities.tabs.programs.index', compact('university', 'programs', 'q', 'isActive', 'level', 'levels'));
    }

    public function create(University $university)
    {
        $intakeOptions = $this->intakeOptions();
        return view('admin.universities.tabs.programs.create', compact('university', 'intakeOptions'));
    }

    public function store(University $university, UniversityProgramStoreRequest $request)
    {
        $data = $request->validated();

        $data['university_id'] = $university->id;
        $data['slug']          = $data['slug'] ?: Str::slug($data['title']);
        $data['is_active']     = (bool) ($data['is_active'] ?? false);
        $data['sort_order']    = (int) ($data['sort_order'] ?? 0);
        $data['intake_months'] = $data['intake_months'] ?? null;

        UniversityProgram::create($data);

        return redirect()
            ->route('universities.programs.index', $university)
            ->with('success', 'Program created successfully.');
    }

    public function edit(University $university, UniversityProgram $program)
    {
        abort_unless($program->university_id === $university->id, 404);

        $intakeOptions = $this->intakeOptions();
        return view('admin.universities.tabs.programs.edit', compact('university', 'program', 'intakeOptions'));
    }

    public function update(University $university, UniversityProgram $program, UniversityProgramUpdateRequest $request)
    {
        abort_unless($program->university_id === $university->id, 404);

        $data = $request->validated();

        $data['slug']          = $data['slug'] ?: Str::slug($data['title']);
        $data['is_active']     = (bool) ($data['is_active'] ?? false);
        $data['sort_order']    = (int) ($data['sort_order'] ?? 0);
        $data['intake_months'] = $data['intake_months'] ?? null;

        $program->update($data);

        return redirect()
            ->route('universities.programs.index', $university)
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(University $university, UniversityProgram $program)
    {
        abort_unless($program->university_id === $university->id, 404);

        $program->delete();

        return redirect()
            ->route('universities.programs.index', $university)
            ->with('success', 'Program deleted successfully.');
    }

    private function intakeOptions(): array
    {
        return [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ];
    }
}
