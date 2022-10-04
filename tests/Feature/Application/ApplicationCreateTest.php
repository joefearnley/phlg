<?php

namespace Tests\Feature\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;

class ApplicationCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_create_an_application_without_a_name()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('applications.store'), [
                'name' => ''
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('name');
    }

    public function test_can_create_an_application()
    {
        $user = User::factory()->create();

        $applicationName = 'Test Application';

        $response = $this->actingAs($user)
            ->post(route('applications.store'), [
                'name' => $applicationName
            ]);

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', 'Application - ' . $applicationName . ' - has been created!');

        $this->assertDatabaseHas('applications', [
            'name' => $applicationName,
        ]);

        $application = Application::where('name', $applicationName)->first();

        $this->assertNotNull($application->app_id);
        $this->assertEquals(12, strlen($application->app_id));
    }
}
