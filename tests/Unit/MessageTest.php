<?php

namespace Tests\Feature;

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
            'type' => 'error'
        ]);

        $this->get('/messages')
            ->assertStatus(200)
            ->assertJsonFragment([ 
                'application_id' => "$application->id",
                'body' => 'This is an error',
                'type' => 'error'
            ]);
    }

    /** @test */
    public function it_shows_an_info_message()
    {
        $application = factory(Application::class)->create(['name' => 'mobile app']);

        factory(Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is some info',
            'type' => 'info'
        ]);

        $this->get('/messages')
            ->assertStatus(200)
            ->assertJsonFragment([
                'application_id' => "$application->id",
                'body' => 'This is some info',
                'type' => 'info'
            ]);
    }

    /** @test */
    public function it_show_a_warning_message()
    {
        $application = factory(Application::class)->create();

        factory(Message::class)->create([
            'application_id' => $application->id,
            'body' => 'This is a warning',
            'type' => 'warning'
        ]);

        $this->get('/messages')
            ->assertStatus(200)
            ->assertJsonFragment([
                'application_id' => "$application->id",
                'body' => 'This is a warning',
                'type' => 'warning'
            ]);
    }
}
