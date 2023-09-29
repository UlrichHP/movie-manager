<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;

use function rand;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Movie::factory()
            ->has(Genre::factory()->count(rand(1, 2)))
            ->has(Actor::factory()->count(rand(1, 3)))
            ->count(20)
            ->create();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
