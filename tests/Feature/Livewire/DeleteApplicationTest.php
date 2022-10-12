<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DeleteApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\ApplicationSeeder;

class DeleteApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_component_can_render()
    {
        $component = Livewire::test(DeleteApplication::class);

        $component->assertStatus(200);
    }

    public function test_application_page_contains_delete_application_component()
    {
        $user = User::factory()->create();

        $this->seed([
            ApplicationSeeder::class,
        ]);

        $this->actingAs($user)
            ->get(route('applications.index'))
            ->assertSeeLivewire('delete-application');
    }

    public function test_applications_can_be_deleted()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $application = $user->applications->first();
        $messages = $user->messages;

        $component = Livewire::actingAs($user)
            ->test(DeleteApplication::class, ['application'=> $application])
            ->call('delete')
            ->assertSet('confirmingDeletion', false);

        $this->assertDatabaseMissing('applications', [
            'id' => $application->id,
        ]);

        foreach($user->messages as $message) {
            $this->assertDatabaseMissing('messages', [
                'id' => $message->id,
            ]);
        }
    }
}
