<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_see_user_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->get('/user');

        $response->assertStatus(200);
    }
}
