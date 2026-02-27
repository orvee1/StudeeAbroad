<?php
namespace Database\Seeders;

use App\Models\University;
use App\Models\UniversityProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UniversityProgramSeeder extends Seeder
{
    public function run(): void
    {
        $levels  = ['Bachelor', 'Master', 'PhD', 'Diploma'];
        $fields  = ['Computer Science', 'Business', 'Engineering', 'Public Health', 'Data Science'];
        $intakes = ['January', 'May', 'September'];

        $universities = University::query()->orderBy('id')->get();

        foreach ($universities as $u) {
            // 3 programs per university
            for ($i = 1; $i <= 3; $i++) {
                $title = "{$levels[$i % 4]} in {$fields[$i % 5]}";
                $slug  = Str::slug($title) . '-' . $i;

                UniversityProgram::updateOrCreate(
                    ['university_id' => $u->id, 'slug' => $slug],
                    [
                        'title'                => $title,
                        'level'                => $levels[$i % 4],
                        'field'                => $fields[$i % 5],
                        'duration_months'      => [24, 12, 48, 18][$i % 4],
                        'language'             => 'English',
                        'tuition_per_year_min' => rand(3000, 15000),
                        'tuition_per_year_max' => rand(16000, 45000),
                        'intake_months'        => $intakes,
                        'entry_requirements'   => 'GPA, language proficiency, and required documents.',
                        'notes'                => 'Demo program notes.',
                        'is_active'            => true,
                        'sort_order'           => $i,
                    ]
                );
            }
        }
    }
}
