<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class SearchMessagesTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_search_messages_with_no_parameters()
    {
        $response = $this->actingAs($this->user)
            ->get(route('messages.index'));

        $response->assertStatus(200);
    }


    public function test_search_by_application()
    {
        

        $response = $this->actingAs($this->user)
            ->get(route('messages.index') . 'appid=' . $application->id);


    }
}
