<?php

namespace Tests\Feature\Application\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\Message;
use App\Models\MessageLevel;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\ApplicationSeeder;

class ApplicationDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_delete_an_application_when_not_authorized()
    {
        $user = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user->applications->first();

        $response = $this->get(route('applications.destroy', $application));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_cannot_delete_an_application_that_user_does_not_own()
    {
        $user1 = User::factory()
            ->hasApplications(1)
            ->create();

        $user2  = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user2->applications->first();

        $formData = [
            '_method' => 'DELETE',
        ];

        $response = $this->actingAs($user1)
            ->post(route('applications.destroy', $application), $formData);

        $response->assertStatus(403);
    }

    public function test_can_delete_an_application()
    {
        $user = User::factory()
            ->hasApplications(1)
            ->create();

        $application = $user->applications->first();

        $formData = [
            '_method' => 'DELETE',
        ];

        $response = $this->actingAs($user)
            ->post(route('applications.destroy',  $application), $formData);

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', 'Application has been deleted!');

        $this->assertDatabaseMissing('applications', [
            'id' => $application->id,
        ]);
    }

    public function test_can_delete_an_application_with_messages()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
        ]);

        $application = Application::first();

        $messages = Message::factory()
            ->count(3)
            ->create([
                'level_id' => MessageLevel::first(),
                'application_id' => $application->id
            ]);

        $messageIds = $messages->pluck('id');

        $applicationName = $application->name;

        $formData = [
            '_method' => 'DELETE',
        ];

        $response = $this->actingAs($user)
            ->post(route('applications.destroy',  $application), $formData);

        $response->assertStatus(302)
            ->assertSessionHas('message_type', 'success')
            ->assertSessionHas('message', 'Application has been deleted!');

        $this->assertDatabaseMissing('applications', [
            'name' => $applicationName,
        ])->assertDatabaseMissing('messages', [
            'id' => $messageIds[0],
        ])->assertDatabaseMissing('messages', [
            'id' => $messageIds[1],
        ])->assertDatabaseMissing('messages', [
            'id' => $messageIds[2],
        ]);
    }
}
