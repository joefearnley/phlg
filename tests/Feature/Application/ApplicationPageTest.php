<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use Database\Seeders\MessageLevelSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\ApplicationSeeder;

class ApplicationPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_view_applications_page_if_not_authorized()
    {
        $response = $this->get(route('applications.index'));

        $response->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_can_view_applications_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('applications.index'));

        $response->assertStatus(200)
            ->assertSee('Applications');
    }

    public function test_applications_page_data_shows_correctly()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
            MessageSeeder::class,
        ]);

        $application = Application::first();

        $response = $this->actingAs($user)
            ->get(route('applications.index'));

        $response->assertStatus(200)
            ->assertSee('Applications')
            ->assertSee($application->name)
            ->assertSee($application->messages->count())
            ->assertSee($application->lastUpdated());
    }

    public function test_applications_page_data_application_last_updated_when_it_does_not_have_any_messages()
    {
        $user = User::factory()->create();

        $this->seed([
            MessageLevelSeeder::class,
            ApplicationSeeder::class,
        ]);

        $application = Application::first();

        $response = $this->actingAs($user)
            ->get(route('applications.index'));

        $response->assertStatus(200)
            ->assertSee('Applications')
            ->assertSee($application->name)
            ->assertSee($application->messages->count())
            ->assertSee($application->lastUpdated());
    }
}
