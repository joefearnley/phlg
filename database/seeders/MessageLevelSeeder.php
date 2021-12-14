<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageLevel;

class MessageLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MessageLevel::factory()
            ->create(
                ['name' => 'INFO'],
                ['name' => 'ERROR'],
                ['name' => 'DEBUG']
            );
    }
}
