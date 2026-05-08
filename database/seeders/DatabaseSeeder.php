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
        User::updateOrCreate(
            ['email' => 'ahmadshihabuddin40@gmail.com'],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ]
        );

        User::factory(3)->create();
    }
}
