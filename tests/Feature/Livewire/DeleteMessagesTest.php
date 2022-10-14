<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DeleteMessages;
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

class DeleteMessagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_component_can_render()
    {
        $component = Livewire::test(DeleteMessages::class);

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
            ->get(route('messages.index'))
            ->assertSeeLivewire('delete-messages');
    }

    public function test_all_messages_can_be_deleted()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
        ]);

        $application = $user->applications->first();

        $messages = Message::factory()->count(3)->make([
            'application_id' => $application->id,
            'level_id' => 1,
        ]);

        $component = Livewire::actingAs($user)
            ->test(DeleteMessages::class)
            ->call('delete')
            ->assertSet('confirmingDeletion', false);

        $this->assertDatabaseMissing('messages', [
            'id' => $messages[0]->id,
        ])
        ->assertDatabaseMissing('messages', [
            'id' => $messages[1]->id,
        ])
        ->assertDatabaseMissing('messages', [
            'id' => $messages[2]->id,
        ]);

        $this->assertEquals(0, $user->messages->count());
    }
}
