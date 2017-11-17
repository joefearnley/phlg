<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Message;
use App\Application;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_messages()
    {
        $application = factory(Application::class)->create(['name' => 'mobile app']);

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

        $this->get('/')
            ->assertStatus(200)
            ->assertViewIs('messages')
            ->assertSee('This is an error')
            ->assertSee('This is some info')
            ->assertSee('This is a warning');
    }
}
