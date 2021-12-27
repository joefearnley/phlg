<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Application;
use App\Models\Message;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\ApplicationSeeder;

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
}
