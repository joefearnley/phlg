<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class WelcomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_sees_welcome_page_if_not_logged_in()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Log in')
            ->assertSee('Sign up');
    }

    public function test_user_is_redirect_to_dashboard_if_logged_in()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(302)
            ->assertRedirect(route('dashboard'));
    }
}
