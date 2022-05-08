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
        $response = $this->post('account.create-token');

        $response->assertStatus(404);
    }
}
