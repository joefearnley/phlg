<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CreateAccessTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_create_token_route_when_user_is_not_authenticated()
    {
        $response = $this->post('account.create-token');

        $response->assertStatus(404);
    }

    public function test_create_access_token()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('account.create-token'));

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', 'A new access token has been created. Make sure to copy your now as you will not be able to see it again.')
            ->assertSessionHas('access_token');
    }
}
