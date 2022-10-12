<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\MessageLevel;
use App\Models\Message;
use Laravel\Sanctum\Sanctum;

class MessageApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $application;
    private $messageLevel;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->application = Application::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Test Application',
        ]);

        $this->messageLevel = MessageLevel::factory()->create([
            'name' => 'INFO'
        ]);
    }

    public function test_cannot_store_messages_page_if_not_authorized()
    {
        $message = 'This is a message';
        $postData = [
            'application_id' => null,
            'message_lavel' => $this->messageLevel->id,
            'message' => 'This is a message',
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(401);
    }

    public function test_cannot_store_messages_without_required_fields()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'application_id' => [ 'The application id field is required.' ],
                'body' => [ 'The body field is required.' ],
                'level_id' => [ 'The level id field is required.' ],
            ]);
    }

    public function test_cannot_store_messages_without_application_id()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [
            'level_id' => $this->messageLevel->id,
            'body' => 'this is a message'
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'application_id' => [ 'The application id field is required.' ],
            ]);
    }

    public function test_cannot_store_messages_with_invalid_application()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [
            'application_id' => 1234,
            'level_id' => $this->messageLevel->id,
            'body' => 'this is a message',
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'The selected application id is invalid.',
                'errors' => [
                    'application_id' => [ 'The selected application id is invalid.' ]
                ],
            ]);
    }

    public function test_cannot_store_messages_without_message_level_id()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [
            'application_id' => $this->application->id,
            'body' => 'this is a message',
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'level_id' => [ 'The level id field is required.' ],
            ]);
    }

    public function test_cannot_store_messages_with_invalid_message_level()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [
            'application_id' => $this->application->id,
            'level_id' => 1234,
            'body' => 'this is a message',
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'The selected level id is invalid.',
                'errors' => [
                    'level_id' => [ 'The selected level id is invalid.' ]
                ],
            ]);
    }

    public function test_cannot_store_messages_without_message_body()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [
            'application_id' => $this->application->id,
            'level_id' => $this->messageLevel->id,
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'body' => [ 'The body field is required.' ],
            ]);
    }

    public function test_can_store_message()
    {
        Sanctum::actingAs($this->user, ['*']);

        $postData = [
            'application_id' => $this->application->id,
            'level_id' => $this->messageLevel->id,
            'body' => 'This is a message.',
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'application_id' => $this->application->id,
                'level_id' => $this->messageLevel->id,
                'body' => 'This is a message.',
            ]);

        $this->assertDatabaseHas('messages', [
            'application_id' => $this->application->id,
            'level_id' => $this->messageLevel->id,
            'body' => 'This is a message.',
        ]);
    }
}
