<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Application;
use App\Models\Message;
use App\Models\User;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\ApplicationSeeder;
use Carbon\Carbon;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_correct_color()
    {
        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
        ]);

        $applicationId = Application::first()->id;

        $infoMessage = Message::factory()->create([
            'application_id' => $applicationId,
            'level_id' => 1
        ]);

        $errorMessage = Message::factory()->create([
            'application_id' => $applicationId,
            'level_id' => 2
        ]);

        $debugMessage = Message::factory()->create([
            'application_id' => $applicationId,
            'level_id' => 3
        ]);

        $this->assertEquals('emerald', $infoMessage->level->color());
        $this->assertEquals('red', $errorMessage->level->color());
        $this->assertEquals('amber', $debugMessage->level->color());
    }

    public function test_has_correct_formatted_creation_timestamp()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $message = Message::first();

        $createdAtFormattedTime = Carbon::parse($message->created_at)->format('m/d/Y h:i a');

        $this->assertEquals($createdAtFormattedTime, $message->formattedCreationTime());
    }

    public function test_has_correct_formatted_updated_timestamp()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $message = Message::first();

        $updatedAtFormattedTime = Carbon::parse($message->updated_at)->format('m/d/Y h:i a');

        $this->assertEquals($updatedAtFormattedTime, $message->formattedUpdateTime());
    }
}
