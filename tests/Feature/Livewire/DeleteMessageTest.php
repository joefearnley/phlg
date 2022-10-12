<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DeleteMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\Message;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\ApplicationSeeder;

class DeleteMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_component_can_render()
    {
        $component = Livewire::test(DeleteMessage::class);

        $component->assertStatus(200);
    }

    public function test_message_page_contains_delete_message_component()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $this->actingAs($user)
            ->get(route('applications.index'))
            ->assertSeeLivewire('delete-application');
    }

    public function test_messages_can_be_deleted()
    {
        $user = User::factory()->create();



        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $application = $user->applications->first();
        $message = $user->messages->first();

        $component = Livewire::actingAs($user)
            ->test(DeleteMessage::class, ['message'=> $message])
            ->call('delete')
            ->assertSet('confirmingDeletion', false);

        $this->assertDatabaseMissing('messages', [
            'id' => $message->id,
        ]);
    }
}
