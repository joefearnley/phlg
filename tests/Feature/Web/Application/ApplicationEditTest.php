<?php

namespace Tests\Feature\Application\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;

class ApplicationEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_edit_an_application_when_not_authorized()
    {
        $user = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user->applications->first();

        $response = $this->get(route('applications.edit', $application));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_cannot_edit_an_application_that_user_does_not_own()
    {
        $user1 = User::factory()
            ->hasApplications(1)
            ->create();

        $user2  = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user2->applications->first();

        $response = $this->actingAs($user1)
            ->get(route('applications.edit', $application));

        $response->assertStatus(403);
    }

    public function test_cannot_update_an_application_when_not_authorized()
    {
        $user = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user->applications->first();

        $formData = [
            'name'=> 'Test Application Updated',
            'active'=> '1',
        ];

        $response = $this->put(route('applications.update', $application), $formData);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_cannot_update_an_application_that_user_does_not_own()
    {
        $authUser = User::factory()
            ->hasApplications(1)
            ->create();

        $unAuthUser  = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $unAuthUser->applications->first();

        $formData = [
            '_method' => 'PUT',
            'name'=> 'Test Application Updated',
            'active'=> '1',
        ];

        $response = $this->actingAs($authUser)
            ->post(route('applications.update', $application), $formData);

        $response->assertStatus(403);

        $this->assertDatabaseHas('applications', [
            'name' => $application->name,
        ]);
    }

    public function test_cannot_update_an_application_without_a_name()
    {
        $user = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user->applications->first();

        $formData = [
            '_method' => 'PUT',
            'name'=> '',
            'active'=> '1',
        ];

        $response = $this->actingAs($user)
            ->post(route('applications.update', $application), $formData);

        $response->assertStatus(302)
            ->assertSessionHasErrors('name');
    }

    public function test_can_edit_and_update_an_application()
    {
        $user = User::factory()->create();

        $application = Application::factory()->create([
            'name' => 'Test Application',
            'user_id' => $user->id,
        ]);

        $newApplicationName = 'Test Application Updated';

        $formData = [
            '_method' => 'PUT',
            'name'=> $newApplicationName,
            'active'=> '1',
        ];

        $response = $this->actingAs($user)
            ->post(route('applications.update',  $application), $formData);

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', '<strong>' . $newApplicationName . '</strong> has been updated!');

        $this->assertDatabaseHas('applications', [
            'name' => $newApplicationName,
        ]);
    }

    public function test_can_deactivate_an_application()
    {
        $user = User::factory()->create();

        $applicationName = 'Test Application';

        $application = Application::factory()->create([
            'name' => $applicationName,
            'user_id' => $user->id,
        ]);

        $formData = [
            '_method' => 'PUT',
            'name'=> $applicationName,
        ];

        $response = $this->actingAs($user)
            ->post(route('applications.update',  $application), $formData);

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', '<strong>' . $applicationName . '</strong> has been updated!');

        $this->assertDatabaseHas('applications', [
            'name' => $applicationName,
            'active' => '0',
        ]);
    }

    public function test_can_activate_an_application()
    {
        $user = User::factory()->create();

        $applicationName = 'Test Application';

        $application = Application::factory()->create([
            'name' => $applicationName,
            'user_id' => $user->id,
        ]);

        $formData = [
            '_method' => 'PUT',
            'name'=> $applicationName,
            'active' => 'on',
        ];

        $response = $this->actingAs($user)
            ->post(route('applications.update',  $application), $formData);

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', '<strong>' . $applicationName . '</strong> has been updated!');

        $this->assertDatabaseHas('applications', [
            'name' => $applicationName,
            'active' => '1',
        ]);
    }
}
