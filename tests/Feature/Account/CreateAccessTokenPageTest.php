<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CreateAccessTokenPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_token_page_when_user_is_not_authenticated()
    {
        $response = $this->get(route('account.access-tokens'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_can_view_access_tokens_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('account.access-tokens'));

        $response->assertStatus(200)
            ->assertSee('Access Tokens')
            ->assertSee('Generate New Token');

    }
}
