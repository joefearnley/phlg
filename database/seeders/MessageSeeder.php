<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Message;
use App\Models\MessageLevel;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::factory()
            ->create([
                'application_id' => Application::first()->id,
                'level_id' => MessageLevel::whereName('INFO')->first()->id,
                'body' => 'This is an INFO logging message.',
            ])
            ->create([
                'application_id' => Application::first()->id,
                'level_id' => MessageLevel::whereName('ERROR')->first()->id,
                'body' => 'This is an ERROR logging message.',
            ])
            ->create([
                'application_id' => Application::first()->id,
                'level_id' => MessageLevel::whereName('DEBUG')->first()->id,
                'body' => 'This is a DEBUG logging message.',
            ]);
    }
}
