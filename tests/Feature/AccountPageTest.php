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

    public function test_can_update_account_information()
    {
        $user = User::factory()->create([
            'name' => 'Joe Smith',
            'email' => 'jsmith123@gmail.com'
        ]);

        $updatedUserName = 'John Doe';
        $updatedUserEmail = 'john.doe123@gmail.com';

        $response = $this->actingAs($user)
            ->post('/account/update', [
                'name' => $updatedUserName,
                'email' => $updatedUserEmail
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => $updatedUserName,
            'email' => $updatedUserEmail
        ]);
    }

    public function test_name_is_required_to_update_account_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('account.update'), [
                'name' => '',
                'email' => $user->email,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required_to_update_account_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('account.update'), [
                'name' => $user->name,
                'email' => '',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function test_cannot_new_password_field_is_required_to_update_password()
    {
        $user = User::factory()->create();

        $newPassword = 'secret123';

        $response = $this->actingAs($user)
            ->post(route('account.update-password'), [
                'new_password' => '',
                'new_password_confirmation' => $newPassword,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('new_password_confirmation');
    }
}
