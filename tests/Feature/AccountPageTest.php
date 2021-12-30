<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function test_name_is_required_to_update_account_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('account.update'), [
                'name' => '',
                'email' => $user->email,
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('name');
    }

    public function test_email_is_required_to_update_account_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('account.update'), [
                'name' => $user->name,
                'email' => '',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('email');
    }

    public function test_can_update_account_information()
    {
        $user = User::factory()->create([
            'name' => 'Joe Smith',
            'email' => 'jsmith123@gmail.com'
        ]);

        $updatedUserName = 'John Doe';
        $updatedUserEmail = 'john.doe123@gmail.com';

        $this->assertDatabaseMissing('users', [
            'name' => $updatedUserName,
            'email' => $updatedUserEmail
        ]);

        $response = $this->actingAs($user)
            ->post('/account/update', [
                'name' => $updatedUserName,
                'email' => $updatedUserEmail
            ]);

        $response->assertStatus(302)
            ->assertSessionHas('status', 'Your account has been updated!');

        $this->assertDatabaseHas('users', [
            'name' => $updatedUserName,
            'email' => $updatedUserEmail
        ]);
    }

    public function test_new_password_field_is_required_to_update_password()
    {
        $user = User::factory()->create();

        $newPassword = 'secret123';

        $response = $this->actingAs($user)
            ->post(route('account.update-password'), [
                'new_password' => '',
                'new_password_confirmation' => $newPassword,
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('new_password');
    }

    public function test_new_password_confirmation_field_is_required_to_update_password()
    {
        $user = User::factory()->create();

        $newPassword = 'secret123';

        $response = $this->actingAs($user)
            ->post(route('account.update-password'), [
                'new_password' => $newPassword,
                'new_password_confirmation' => '',
            ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('new_password_confirmation');
    }

    public function test_new_passwords_must_match_to_update_password()
    {
        $user = User::factory()->create();

        $newPassword = 'secret123';

        $response = $this->actingAs($user)
            ->post(route('account.update-password'), [
                'new_password' => $newPassword,
                'new_password_confirmation' => 'asdfasdfasdf',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('new_password');
    }

    public function test_can_update_password()
    {
        $user = User::factory()->create();

        $newPassword = 'secret123';

        $response = $this->actingAs($user)
            ->post(route('account.update-password'), [
                'new_password' => $newPassword,
                'new_password_confirmation' => $newPassword,
            ]);

        $response->assertStatus(302)
            ->assertSessionHas('status', 'Your password has been updated!');

        $this->assertTrue(Hash::check($newPassword, $user->password));
    }
}
