<?php

namespace Tests\Feature\Api;

use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting a list of applications.
     */
    public function test_can_list_applications()
    {
        Application::factory()->count(5)->create();

        $response = $this->getJson('/api/applications');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    /**
     * Test getting a specific application.
     */
    public function test_can_show_application()
    {
        $application = Application::factory()->create([
            'pinCode' => 'PIN12345'
        ]);

        // Test lookup by ID
        $response = $this->getJson("/api/applications/{$application->id}");
        $response->assertStatus(200)
            ->assertJsonPath('id', $application->id);

        // Test lookup by PIN code
        $response = $this->getJson("/api/applications/PIN12345");
        $response->assertStatus(200)
            ->assertJsonPath('id', $application->id);
    }

    /**
     * Test updating application status.
     */
    public function test_can_update_status()
    {
        $application = Application::factory()->create(['status' => 0]);

        $response = $this->postJson("/api/applications/{$application->id}/status", [
            'status' => 1
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('application.status', 1);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 1
        ]);
    }

    /**
     * Test updating status with invalid data.
     */
    public function test_status_update_validation()
    {
        $application = Application::factory()->create();

        $response = $this->postJson("/api/applications/{$application->id}/status", [
            'status' => 'not-an-integer'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors' => ['status']]);
    }
}
