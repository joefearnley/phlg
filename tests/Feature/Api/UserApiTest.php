<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_see_user_information()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['view-user']);

        $response = $this->get('/api/user');

        $response->assertOk();
    }

    public function test_user_information_not_found_when_not_authenticated()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user, 'api')
            ->get('/user');

        $response->assertNotFound();
    }
}
