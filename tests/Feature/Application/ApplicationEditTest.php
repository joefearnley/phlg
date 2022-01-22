<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;

class ApplicationEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_update_an_application_when_not_authorized()
    {
        $user = User::factory()->create();
        $application = Application::factory()->create([
            'name'=> 'Test Application',
            'user_id' => $user->id,
        ]);

        $formData = [
            'name'=> 'Test Application Updated',
        ];

        $response = $this->put(route('applications.update', $application), $formData);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_cannot_update_an_application_that_user_does_not_own()
    {
        $authUser = User::factory()->create();
        $unAuthUser  = User::factory()->create();
        $application = Application::factory()->create([
            'name'=> 'Test Application',
            'user_id' => $unAuthUser->id,
        ]);

        $formData = [
            '_method' => 'PUT',
            'name'=> 'Test Application Updated',
        ];

        $response = $this->actingAs($authUser)
            ->post(route('applications.update'), $formData);

        $response->assertStatus(302)
            ->assertSessionHasErrors('name');
    }

    // public function test_cannot_update_an_application_without_a_name()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)
    //         ->post(route('applications.store'), [
    //             'name' => ''
    //         ]);

    //     $response->assertStatus(302)
    //         ->assertSessionHasErrors('name');
    // }

    // public function test_edit_create_an_application()
    // {
    //     $user = User::factory()->create();

    //     $application = Application::factory()->create([
    //         'name'=> 'Test Application',
    //         'user_id' => $user->id,
    //     ]);

    //     $newApplicationName = 'Test Application 1';

    //     $response = $this->actingAs($user)
    //         ->post(route('applications.store'), [
    //             'name' => $applicationName
    //         ]);

    //     $response->assertStatus(302)
    //         ->assertSessionHas('message_type', 'success')
    //         ->assertSessionHas('message', 'Application - ' . $applicationName . ' - has been created!');

    //     $this->assertDatabaseHas('applications', [
    //         'name' => $applicationName,
    //     ]);
    // }
}
