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
        $app = factory(Application::class)->create(['name' => 'mobile app']);
        factory(Message::class)->create([ 
            'application_id' => $app->id,
            'body' => 'This is an error',
            'type' => 'error'
        ]);

        // factory(Message::class)->create([ 
        //     'app_id' => $app->id,
        //     'body' => 'This is some info',
        //     'type' => 'info'
        // ]);

        // factory(Message::class)->create([ 
        //     'app_id' => $app->id,
        //     'body' => 'This is some info',
        //     'type' => 'info'
        // ]);

        $this->get('/messages')
            ->assertStatus(200)
            ->assertJsonFragment([ 
                'application_id' => "$app->id",
                'body' => 'This is an error',
                'type' => 'error'
            ]);
    }
}
