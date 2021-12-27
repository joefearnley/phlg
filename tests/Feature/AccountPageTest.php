<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_account_page_if_not_authorized()
    {
        $response = $this->get('/account');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
