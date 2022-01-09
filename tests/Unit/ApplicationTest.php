<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\ApplicationSeeder;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_correct_formatted_creation_timestamp()
    {
        $user = User::factory()->create();
        $this->seed([ ApplicationSeeder::class ]);

        $application = Application::first();

        $createdAtFormattedTime = Carbon::parse($application->created_at)->format('m/d/Y h:i a');

        $this->assertEquals($createdAtFormattedTime, $application->formattedCreationTime());
    }

    public function test_has_correct_formatted_updated_timestamp()
    {
        $user = User::factory()->create();

        $this->seed([ ApplicationSeeder::class ]);

        $application = Application::first();

        $updatedAtFormattedTime = Carbon::parse($application->updated_at)->format('m/d/Y h:i a');

        $this->assertEquals($updatedAtFormattedTime, $application->formattedUpdateTime());
    }
}
