<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AccountPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_account_page_if_not_authorized()
    {
        $response = $this->get('/account');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_can_view_account_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/account');

        $response->assertStatus(200)
            ->assertSee('Account');
    }
}
