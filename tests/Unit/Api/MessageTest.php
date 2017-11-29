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
    public function it_shows_an_error_message()
    {
        $application = factory(Application::class)->create();

        factory(Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is an error',
            'level' => 'error'
        ]);

        $this->get('/api/messages')
            ->assertStatus(200)
            ->assertJsonFragment([ 
                'application_id' => "$application->id",
                'body' => 'This is an error',
                'level' => 'error'
            ]);
    }

    /** @test */
    public function it_shows_an_info_message()
    {
        $application = factory(Application::class)->create();

        factory(Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is some info',
            'level' => 'info'
        ]);

        $this->get('/api/messages')
            ->assertStatus(200)
            ->assertJsonFragment([
                'application_id' => "$application->id",
                'body' => 'This is some info',
                'level' => 'info'
            ]);
    }

    /** @test */
    public function it_show_a_warning_message()
    {
        $application = factory(Application::class)->create();

        factory(Message::class)->create([
            'application_id' => $application->id,
            'body' => 'This is a warning',
            'level' => 'warning'
        ]);

        $this->get('/api/messages')
            ->assertStatus(200)
            ->assertJsonFragment([
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

        $response = $this->post('/api/messages', $message);

        $response->assertStatus(200)
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
    public function it_should_throw_exception_if_no_body_is_provided()
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
    public function it_should_throw_exception_if_no_level_is_provided()
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
