<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Lead;
use App\Models\State;
use App\Models\University;
use App\Models\UniversityProgram;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_destination_university_and_program_pages_render_from_catalog_data(): void
    {
        [$country, $university, $program] = $this->createCatalog();

        $this->get('/destinations/' . $country->slug)
            ->assertOk()
            ->assertSee('Canada');

        $this->get('/universities/' . $university->slug)
            ->assertOk()
            ->assertSee('Northstar University')
            ->assertSee('Computer Science');

        $this->get('/universities/' . $university->slug . '/programs/' . $program->slug)
            ->assertOk()
            ->assertSee('Bachelor of Computer Science')
            ->assertSee('Northstar University');
    }

    public function test_program_filters_return_matching_active_catalog_entries(): void
    {
        [, , $program] = $this->createCatalog();

        $this->get('/programs?level=Bachelor&field=Computing')
            ->assertOk()
            ->assertSee($program->title)
            ->assertSee('1 program found');

        $this->get('/programs?level=Doctorate')
            ->assertOk()
            ->assertDontSee($program->title)
            ->assertSee('No programs match those filters');
    }

    public function test_semester_tuition_is_displayed_and_annualized_for_program_search(): void
    {
        [$country, $university, $program] = $this->createCatalog();
        $program->update([
            'tuition_per_year_min' => null,
            'tuition_per_year_max' => null,
            'tuition_per_semester_min' => 10000,
            'tuition_per_semester_max' => 12000,
            'semesters_per_year' => 2,
        ]);

        $this->get('/programs?tuition_min=19000&tuition_max=25000')
            ->assertOk()
            ->assertSee($program->title)
            ->assertSee('CAD 20,000–24,000')
            ->assertSee('CAD 10,000–12,000 / semester')
            ->assertSee('2 semesters per year');

        $this->get('/programs?tuition_min=25001')
            ->assertOk()
            ->assertDontSee($program->title);

        $this->get('/universities/' . $university->slug . '/programs/' . $program->slug)
            ->assertOk()
            ->assertSee('Annual tuition estimate')
            ->assertSee('CAD 20,000–24,000')
            ->assertSee('Tuition per semester')
            ->assertSee('2 semesters per year');
    }

    public function test_university_search_returns_a_public_profile_link(): void
    {
        [$country, $university] = $this->createCatalog();

        $this->get('/search?country_id=' . $country->id)
            ->assertOk()
            ->assertSee($university->name)
            ->assertSee('View university')
            ->assertSee('/universities/' . $university->slug);
    }

    public function test_public_guidance_request_is_saved_for_admin_follow_up(): void
    {
        [$country, $university] = $this->createCatalog();

        $this->post('/enquiries', [
            'name' => 'A Student',
            'email' => 'STUDENT@example.com',
            'phone' => '+1 555 0100',
            'desired_country_id' => $country->id,
            'desired_university_id' => $university->id,
            'desired_level' => 'Bachelor',
            'preferred_intake' => 'September',
            'source' => 'university',
            'message' => 'Please share admission details.',
        ])->assertRedirect();

        $this->assertDatabaseHas('leads', [
            'email' => 'student@example.com',
            'desired_country_id' => $country->id,
            'desired_university_id' => $university->id,
            'status' => 'new',
            'source' => 'university',
        ]);

        $this->assertSame(1, Lead::query()->count());
    }

    private function createCatalog(): array
    {
        $country = Country::query()->create([
            'name' => 'Canada',
            'slug' => 'canada',
            'currency' => 'CAD',
            'is_active' => true,
        ]);

        $state = State::query()->create([
            'country_id' => $country->id,
            'name' => 'Ontario',
            'slug' => 'ontario',
            'is_active' => true,
        ]);

        $city = City::query()->create([
            'state_id' => $state->id,
            'name' => 'Toronto',
            'slug' => 'toronto',
            'is_active' => true,
        ]);

        $university = University::query()->create([
            'country_id' => $country->id,
            'state_id' => $state->id,
            'city_id' => $city->id,
            'name' => 'Northstar University',
            'slug' => 'northstar-university',
            'short_description' => 'A sample catalog university.',
            'is_active' => true,
            'is_featured' => true,
        ]);

        $program = UniversityProgram::query()->create([
            'university_id' => $university->id,
            'title' => 'Bachelor of Computer Science',
            'slug' => 'bachelor-computer-science',
            'level' => 'Bachelor',
            'field' => 'Computing',
            'tuition_per_year_min' => 18000,
            'tuition_per_year_max' => 22000,
            'tuition_per_semester_min' => 9000,
            'tuition_per_semester_max' => 11000,
            'semesters_per_year' => 2,
            'intake_months' => ['September'],
            'is_active' => true,
        ]);

        return [$country, $university, $program];
    }
}
