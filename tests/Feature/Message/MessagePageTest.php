<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
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

        $messages = $user->messages;

        $response = $this->actingAs($user)
            ->get(route('messages.index'));

        $response->assertStatus(200)
            ->assertSee($messages[0]->body)
            ->assertSee($messages[1]->body)
            ->assertSee($messages[2]->body);
    }
}
