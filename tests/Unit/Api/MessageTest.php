<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Message;
use App\Application;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_all_messages()
    {
        $application = factory(Application::class)->create();

        factory(Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is an error',
            'level' => 'error'
        ]);

        factory(Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is some info',
            'level' => 'info'
        ]);

        factory(Message::class)->create([
            'application_id' => $application->id,
            'body' => 'This is a warning',
            'level' => 'warning'
        ]);

        $this->get('/api/messages')
            ->assertStatus(200)
            ->assertJsonFragment([ 
                'application_id' => "$application->id",
                'body' => 'This is an error',
                'level' => 'error'
            ])->assertJsonFragment([
                'application_id' => "$application->id",
                'body' => 'This is some info',
                'level' => 'info'
            ])->assertJsonFragment([
                'application_id' => "$application->id",
                'body' => 'This is a warning',
                'level' => 'warning'
            ]);
    }

    /** @test */
    public function it_can_add_a_message()
    {
        $application = factory(Application::class)->create();
        $message = [
            'application_id' => $application->id,
            'body' => 'This is another error',
            'level' => 'error'
        ];

        $this->post('/api/messages', $message)
            ->assertStatus(200)
            ->assertJsonFragment([
                'application_id' => $application->id,
                'body' => 'This is another error',
                'level' => 'error'
            ]);

        $this->assertDatabaseHas('messages', [
                'application_id' => $application->id,
                'body' => 'This is another error',
                'level' => 'error'
            ]);;
    }

    /** @test */
    public function it_can_show_a_message()
    {
        $application = factory(Application::class)->create();
        $message = factory(Message::class)->create([
            'application_id' => $application->id,
            'body' => 'This is another error',
            'level' => 'error'
        ]);

        $this->get('/api/messages/' . $message->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'application_id' => "$application->id",
                'body' => 'This is another error',
                'level' => 'error'
            ]);
    }

    /** @test */
    public function when_creating_message_throws_exception_if_no_body_is_provided()
    {
        $application = factory(Application::class)->create();
        $message = [
            'application_id' => $application->id,
            'level' => 'error'
        ];

        $this->json('POST', '/api/messages', $message)
            ->assertStatus(422)
            ->assertJsonFragment(['The body field is required.']);
    }

    /** @test */
    public function when_creating_message_throws_exception_if_no_level_is_provided()
    {
        $application = factory(Application::class)->create();
        $message = [
            'application_id' => $application->id,
            'body' => 'this is a message'
        ];

        $this->json('POST', '/api/messages', $message)
            ->assertStatus(422)
            ->assertJsonFragment(['The level field is required.']);
    }

    /** @test */
    public function it_shows_a_message()
    {
        $application = factory(Application::class)->create();
        $message = [
            'application_id' => $application->id,
            'body' => 'this is a message'
        ];

        $this->json('POST', '/api/messages', $message)
            ->assertStatus(422)
            ->assertJsonFragment(['The level field is required.']);
    }
}
