<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // should create an initial user via the registration process
        $user = User::first();

        Application::factory()
            ->create([
                'user_id' => isset($user) ? $user->id : User::factory()->create()->id,
                'name' => 'Test Application',
            ]);
    }
}
