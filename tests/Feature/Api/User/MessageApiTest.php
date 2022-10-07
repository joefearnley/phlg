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

    // private $application;

    // public function setUp()
    // {
    //     parent::setUp();

    //     $this->application = Application::factory()->create([
    //         'name' => 'Test Application',
    //     ]);
    // }

    public function test_cannot_store_messages_page_if_not_authorized()
    {
        $message = 'This is a message';
        $postData = [
            'message' => 'This is a message',
            'message_lavel' => 1,
            'application_id' => null
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(401);
    }

    public function test_cannot_store_messages_without_required_fields()
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $postData = [];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                "application_id" => [ "The application id field is required." ],
                "body" => [ "The body field is required." ],
                "level_id" => [ "The level id field is required." ]
            ]);
    }

    public function test_cannot_store_messages_without_application_id()
    {
        $user = User::factory()->create();

        $application = Application::factory()->create([
            'name' => 'Test Application',
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $postData = [
            'level_id' => 1,
            'body' => 'this is a message'
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                "application_id" => [ "The application id field is required." ],
            ]);
    }

    public function test_cannot_store_messages_with_invalid_application()
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $postData = [
            'application_id' => 1234,
            'level_id' => 1,
            'body' => 'this is a message'
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Application not found.',
                'errors' => [
                    'application_id' => [ 'The application id field is invalid.' ]
                ]
            ]);
    }

    public function test_cannot_store_messages_without_message_level_id()
    {
        $user = User::factory()->create();

        $application = Application::factory()->create([
            'name' => 'Test Application',
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $postData = [
            'application_id' => $application->id,
            'body' => 'this is a message'
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                "level_id" => [ "The level id field is required." ],
            ]);
    }

    public function test_cannot_store_messages_with_invalid_message_level()
    {
        $user = User::factory()->create();

        $application = Application::factory()->create([
            'name' => 'Test Application',
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $postData = [
            'application_id' => $application->id,
            'level_id' => 1234,
            'body' => 'this is a message'
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Message Level not found.',
                'errors' => [
                    'level_id' => [ 'The level id field is invalid.' ]
                ]
            ]);
    }

    public function test_cannot_store_messages_without_message_body()
    {
        $user = User::factory()->create();

        $application = Application::factory()->create([
            'name' => 'Test Application',
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $postData = [
            'application_id' => $application->id,
            'level_id' => 1
        ];

        $response = $this->postJson(route('api.messages.store'), $postData);

        $response->assertStatus(422)
            ->assertJsonFragment([
                "body" => [ "The body field is required." ],
            ]);
    }

    // test successful post
    //  saved to database
    //  correct json is returned
}
