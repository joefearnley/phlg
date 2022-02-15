<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\Message;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\ApplicationSeeder;

class MessagePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_messages_page_if_not_authorized()
    {
        $response = $this->get(route('messages.index'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_can_view_messages_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('messages.index'));

        $response->assertStatus(200)
            ->assertSee('Messages');
    }

    public function test_can_view_users_messages()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $application = $user->applications->first();
        $messages = $user->messages;

        $response = $this->actingAs($user)
            ->get(route('messages.index'));

        $response->assertStatus(200)
            ->assertSee('All Messages')
            ->assertSee($application->name)
            ->assertSee($messages[0]->body)
            ->assertSee($messages[1]->body)
            ->assertSee($messages[2]->body);
    }

    public function test_can_view_applications_filter()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $application = $user->applications->first();
        $messages = $user->messages;

        $response = $this->actingAs($user)
            ->get(route('messages.index'));

        $response->assertStatus(200)
            ->assertSee('Applications')
            ->assertSee($application->name);
    }

    public function test_can_filter_by_applications()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $application = $user->applications->first();
        $messages = $user->messages;

        $application2 = Application::factory()->create([
            'user_id' => $user->id
        ]);

        $application2Messages = Message::factory()
            ->count(3)
            ->create([
                'application_id' => $application2,
                'level_id' => 1,
            ]);

        $response = $this->actingAs($user)
            ->get(route('messages.index', ['appid' => $application->id]));

        $response->assertStatus(200);

        $response->assertSeeText('Messages for ' . $application->name)
            ->assertSee($messages[0]->body)
            ->assertSee($messages[1]->body)
            ->assertSee($messages[2]->body);

        $response->assertDontSee($application2Messages[0]->body)
            ->assertDontSee($application2Messages[1]->body)
            ->assertDontSee($application2Messages[2]->body);
    }
}
