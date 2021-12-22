<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageLevel;

class MessageLevelSeeder extends Seeder
{
    public function run()
    {
        MessageLevel::factory()
            ->create(['name' => 'INFO'])
            ->create(['name' => 'ERROR'])
            ->create(['name' => 'DEBUG']);
    }
}
