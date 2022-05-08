<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_update_account_route_when_user_is_not_authenticated()
    {
        $response = $this->post(route('account.update-password'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
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
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', 'Your password has been updated!');

        $this->assertTrue(Hash::check($newPassword, $user->password));
    }
}
