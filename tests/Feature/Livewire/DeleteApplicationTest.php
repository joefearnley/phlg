<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DeleteApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;

class DeleteApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_component_can_render()
    {
        $component = Livewire::test(DeleteApplication::class);

        $component->assertStatus(200);
    }
}
