<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\Message;
use App\Models\MessageLevel;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\ApplicationSeeder;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_dashboard_if_not_authorized()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_can_view_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('Latest Messages');
    }

    public function test_can_view_with_no_messages()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('Latest Messages')
            ->assertSee('No Messages Yet!');
    }

    public function test_should_see_latest_messages_on_dashboard()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
        ]);

        $application = Application::first();

        $messages = Message::factory()
            ->count(3)
            ->create([
                'level_id' => MessageLevel::first(),
                'application_id' => $application->id
            ]);

        $messageBodies = $messages->pluck('body');

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('Latest Messages')
            ->assertSee($messageBodies[0])
            ->assertSee($messageBodies[1])
            ->assertSee($messageBodies[2]);
    }
}
