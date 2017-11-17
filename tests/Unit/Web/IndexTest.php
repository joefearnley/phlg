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
        $application = factory(Application::class)->create(['name' => 'mobile']);

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

    /** @test */
    public function it_shows_messages_for_applications()
    {
        $application = factory(Application::class)->create(['name' => 'mobile']);

        factory(Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is an error',
            'level' => 'error'
        ]);

        $this->get('/messages/application/'.$application->id)
            ->assertStatus(200)
            ->assertViewIs('messages')
            ->assertSee('mobile');
    }
}
