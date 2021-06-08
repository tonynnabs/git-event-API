<?php

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Seeder;

class ActorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actor1 = Actor::create([
            'login' => 'daniel33',
            'avatar_url' => 'https://avatars.com/2790311',
            'event_id' => 1,
        ]);
        $actor2 = Actor::create([
            'login' => 'eric66',
            'avatar_url' => 'https://avatars.com/2790312',
            'event_id' => 2,
        ]);
    }
}
