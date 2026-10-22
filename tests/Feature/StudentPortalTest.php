<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_signed_in_students_can_still_view_the_public_homepage_and_footer(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->get('/')
            ->assertOk()
            ->assertSee('Explore destinations')
            ->assertSee('All rights reserved.');
    }

    public function test_student_can_review_enquiries_submitted_with_their_email(): void
    {
        $student = User::factory()->create();
        Lead::query()->create([
            'name' => $student->name,
            'email' => strtoupper($student->email),
            'source' => 'landing',
            'status' => 'contacted',
            'message' => 'Please help me plan my application.',
        ]);
        Lead::query()->create([
            'name' => 'Another Student',
            'email' => 'another@example.com',
            'source' => 'landing',
            'status' => 'new',
        ]);

        $this->actingAs($student)
            ->get('/student/dashboard')
            ->assertOk()
            ->assertSee('My enquiries')
            ->assertSee('1');

        $this->actingAs($student)
            ->get('/student/enquiries')
            ->assertOk()
            ->assertSee('Please help me plan my application.')
            ->assertDontSee('Another Student');
    }
}
