<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataApiTest extends TestCase
{
    /** @test */
    public function it_returns_programs_list()
    {
        $response = $this->get('/api/programs/admission');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'HSC']);
    }

    /** @test */
    public function it_returns_admission_sessions_list()
    {
        $response = $this->get('/api/sessions/admission');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => '2025-2026']);
    }

    /** @test */
    public function it_returns_all_sessions_list()
    {
        $response = $this->get('/api/sessions/all');
        $response->assertStatus(200);
        $this->assertGreaterThan(0, count($response->json()));
    }

    /** @test */
    public function it_returns_occupations_list()
    {
        $response = $this->get('/api/occupations');
        $response->assertStatus(200);
        $this->assertContains('Engineer', $response->json());
    }
}
