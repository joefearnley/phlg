<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_information_not_found_when_not_authenticated()
    {
        $response = $this->get(route('api.user'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_user_information()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['view-user']);
        $response = $this->get(route('api.user'));

        $response->assertStatus(200)
            ->assertSee($user->id)
            ->assertSee($user->name);
    }
}
