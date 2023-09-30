<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

use function rand;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();

        $genres = Genre::factory(10)->create();
        $actors = Actor::factory(10)->create();

        Movie::factory(20)
            ->hasAttached($genres->random(1))
            ->hasAttached($actors->random(3))
            ->create();
    }
}
