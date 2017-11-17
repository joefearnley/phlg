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
        $application = factory(Application::class)->create(['name' => 'mobile app']);

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
        $application = factory(Application::class)->create(['name' => 'mobile app']);

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
}
