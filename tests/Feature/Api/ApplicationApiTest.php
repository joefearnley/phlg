<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use Laravel\Sanctum\Sanctum;

class ApplicationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_applications_api_if_not_authenticated()
    {
        $response = $this->get(route('api.applications.index'));

        $response->assertStatus(403);
    }

    public function test_can_view_applications_api_when_authenticated()
    {
        $user = User::factory()->create();

        $application = Application::factory()->create([
            'user_id' => $user->id
        ]);

        Sanctum::actingAs($user, ['view-application']);
        $response = $this->get(route('api.applications.index'));

        $response->assertStatus(200)
            ->assertSee($application->id)
            ->assertSee($application->name);
    }

    public function test_can_only_view_applications_user_owns()
    {
        $user = User::factory()->create();
        $application = Application::factory()->create([
            'user_id' => $user->id
        ]);

        $user2 = User::factory()->create();
        $application2 = Application::factory()->create([
            'user_id' => $user2->id
        ]);

        Sanctum::actingAs($user, ['view-application']);
        $response = $this->get(route('api.applications.index'));

        $response->dump();

        // $response->assertStatus(200)
        //     ->assertSee($application->id)
        //     ->assertSee($application->name)
        //     ->assertDontSee($application2->id)
        //     ->assertDontSee($application2->name);
    }
}
