<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default user if not exists
        User::firstOrCreate(
            ['email' => 'hello@mominul.me'],
            [
                'name' => 'Mominul Islam',
                'password' => bcrypt('password'), // Default password
            ]
        );

        // Seed construction data
        $this->call(ConstructionDataSeeder::class);
    }
}
