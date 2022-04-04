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

class SearchMessagesTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            MessageLevelSeeder::class
        ]);

        $this->user = User::factory()->create();
        $this->application = Application::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->messages = Message::factory([
            'application_id' => $this->application->id,
            'level_id' => 1
        ])
            ->count(3)
            ->create();
    }

    public function test_search_messages_with_no_parameters()
    {
        $response = $this->actingAs($this->user)
            ->get(route('messages.index'));

        $response->assertStatus(200);
    }

    public function test_search_by_application_shows_application_name()
    {
        $response = $this->actingAs($this->user)
            ->get(route('messages.index') . '?appid=' . $this->application->id);

        $response->assertStatus(200)
            ->assertSeeText('Application: ' . $this->application->name);
    }

    public function test_search_only_shows_messages_for_selected_application()
    {
        $application2 = Application::factory()->create([
            'user_id' => $this->user->id
        ]);

        $application2Messages = Message::factory([
            'application_id' => $application2->id,
            'level_id' => 1
        ])
            ->count(3)
            ->create();

        $response = $this->actingAs($this->user)
            ->get(route('messages.index') . '?appid=' . $this->application->id);

        // should show 3 messages from selected application
        $responseData = $response->getOriginalContent()->getData();
        $this->assertEquals($this->messages->count(), $responseData['messages']->count());

        $response->assertStatus(200)
            ->assertSeeText($this->messages[0]->body)
            ->assertSeeText($this->messages[1]->body)
            ->assertSeeText($this->messages[2]->body);

        $response->assertStatus(200)
            ->assertDontSeeText($application2Messages[0]->body)
            ->assertDontSeeText($application2Messages[1]->body)
            ->assertDontSeeText($application2Messages[2]->body);
    }

    public function test_search_for_message_shows_search_term()
    {
        $searchTerm = $this->messages[0]->body;

        $response = $this->actingAs($this->user)
            ->get(route('messages.index') . '?term=' . $searchTerm);

        $response->assertStatus(200)
            ->assertSeeText('Search Term: ' . $searchTerm);
    }

    public function test_search_for_message_shows_messages_that_match_term()
    {
        $searchTerm = $this->messages[0]->body;

        $response = $this->actingAs($this->user)
            ->get(route('messages.index') . '?term=' . $searchTerm);

        $responseData = $response->getOriginalContent()->getData();
        $this->assertEquals(1, $responseData['messages']->count());

        $response->assertStatus(200)
            ->assertSeeText('Search Term: ' . $searchTerm)
            ->assertSee($this->messages[0]->body)
            ->assertDontSeeText($this->messages[1]->body)
            ->assertDontSeeText($this->messages[2]->body);
    }
}
