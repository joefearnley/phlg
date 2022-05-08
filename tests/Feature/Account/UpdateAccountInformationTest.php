<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UpdateAccountInformationTest extends TestCase
{
    use RefreshDatabase;

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
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', 'Your account has been updated!');

        $this->assertDatabaseHas('users', [
            'name' => $updatedUserName,
            'email' => $updatedUserEmail
        ]);
    }
}
