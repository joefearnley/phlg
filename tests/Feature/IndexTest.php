<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_if_not_logged_in()
    {
        $response = $this->get('/');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function user_is_redirect_to_dashboard_if_logged_in()
    {
        $user = User::factory()->create();

        $response = $this->get('/');

        $response->assertStatus(302)
            ->assertRedirect('/dashboard');
    }
}
