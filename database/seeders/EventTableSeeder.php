<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event1 = Event::create([
            'type' => 'PushEvent',
            'actor' => 1,
            'repo' => 2,
        ]);
        $event2 = Event::create([
            'type' => 'PushEvent',
            'actor' => 2,
            'repo' => 1,
        ]);
    }
}
