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

    public function test_lastupdated_is_appliation_updated_at_when_it_does_not_have_messages()
    {
        $user = User::factory()->create();
        $this->seed([
            ApplicationSeeder::class,
        ]);

        $application = Application::first();

        $applicationUpdatedAtFormattedDate = Carbon::parse($application->updated_at)->format('m/d/Y h:i a');

        $this->assertEquals($applicationUpdatedAtFormattedDate, $application->lastUpdated());
    }
}
