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

        $response = $this->post('api/messages/', $postData);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    // public function test_cannot_store_messages_without_required_fields()
    // {
    //     $user = User::factory()->create();

    //     $application = Application::factory()->create([
    //         'name' => 'Test Application',
    //         'user_id' => $user->id,
    //     ]);

    //     Sanctum::actingAs(
    //         $user,
    //         ['*']
    //     );

    //     $postData = [];

    //     $response = $this->post(route('api.messages.store'), $postData);

    //     $response->assertStatus(200);
    // }

    // test for missing application id
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
            'message' => 'this is a message'
        ];

        dd(route('api.messages.store'));

        $response = $this->post(route('api.messages.store'), $postData);

        $response->assertStatus(200);
    }

    // test for valid application

    // test for missoing level id
    // test for valid level

    // test if body is missing

    // test sucess
    //  saved to database
    //  correct json is returned
}
