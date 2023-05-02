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
    use WithFaker;

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

    public function test_should_not_see_latest_messages_from_inactive_application()
    {
        $user = User::factory()->create();

        $this->seed([ MessageLevelSeeder::class, ]);

        $activeApplication = Application::factory()->create([
            'name' => 'Active Application',
            'user_id' => $user->id,
        ]);

        $inactiveApplication = Application::factory()->create([
            'name' => 'Inactive Application',
            'user_id' => $user->id,
            'active' => '0'
        ]);

        $activeMessages = Message::factory()->count(2)
        ->create([
            'application_id' => $activeApplication->id,
            'level_id' => MessageLevel::whereName('INFO')->first()->id,
            'body' => $this->faker->realText(),
        ]);

    $inactiveMessages = Message::factory()->count(2)
        ->create([
            'application_id' => $activeApplication->id,
            'level_id' => MessageLevel::whereName('INFO')->first()->id,
            'body' => $this->faker->realText(),
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard');

            $response->assertStatus(200)
                ->assertSee('Dashboard')
                ->assertSee('Latest Messages')
                ->assertSeeText($activeApplication->name)
                ->assertSee($activeMessages[0]->body)
                ->assertSee($activeMessages[1]->body)
                ->assertDontSeeText($inactiveApplication->name)
                ->assertDontSee($inactiveMessages[0]->body)
                ->assertDontSee($inactiveMessages[1]->body);
    }
}
