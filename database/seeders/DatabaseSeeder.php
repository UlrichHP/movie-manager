<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        User::factory(10)->create();

        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $adminUser->assignRole('admin');

        $genres = Genre::factory(10)->create();
        $actors = Actor::factory(10)->create();

        Movie::factory(20)
            ->hasAttached($genres->random(1))
            ->hasAttached($actors->random(3))
            ->create();
    }
}
