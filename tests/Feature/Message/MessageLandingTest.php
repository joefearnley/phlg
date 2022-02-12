<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageLandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_messages_landing_page_if_not_authorized()
    {
        $response = $this->get(route('messages.index'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
