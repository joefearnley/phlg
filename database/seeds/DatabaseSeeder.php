<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $application = factory(App\Application::class)->create(['name' => 'mobile']);
        $application = factory(App\Application::class)->create(['name' => 'desktop']);

        factory(App\Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is an error',
            'level' => 'error'
        ]);

        factory(App\Message::class)->create([ 
            'application_id' => $application->id,
            'body' => 'This is some info',
            'level' => 'info'
        ]);

        factory(App\Message::class)->create([
            'application_id' => $application->id,
            'body' => 'This is a warning',
            'level' => 'warning'
        ]);
    }
}
