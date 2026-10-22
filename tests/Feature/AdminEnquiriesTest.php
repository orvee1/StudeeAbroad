<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEnquiriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_review_an_enquiry_and_update_its_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $lead = Lead::query()->create([
            'name' => 'A Student',
            'email' => 'student@example.com',
            'source' => 'landing',
            'status' => 'new',
            'message' => 'I need help comparing options.',
        ]);

        $this->actingAs($admin)
            ->get('/admin/leads')
            ->assertOk()
            ->assertSee('A Student')
            ->assertSee('I need help comparing options.');

        $this->actingAs($admin)
            ->patch('/admin/leads/' . $lead->id, ['status' => 'contacted'])
            ->assertRedirect();

        $this->assertDatabaseHas('leads', ['id' => $lead->id, 'status' => 'contacted']);
    }
}
