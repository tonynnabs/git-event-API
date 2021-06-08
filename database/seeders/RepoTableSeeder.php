<?php

namespace Database\Seeders;

use App\Models\Repo;
use Illuminate\Database\Seeder;

class RepoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repo1 = Repo::create([
            'name' => 'johnbolton/exercitationem',
            'url' => 'https://github.com/johnbolton/exercitationem',
            'event_id' => 1,
        ]);

        $repo2 = Repo::create([
            'name' => 'pestrada/voluptatem',
            'url' => 'https://github.com/pestrada/voluptatem',
            'event_id' => 2,
        ]);
    }
}
