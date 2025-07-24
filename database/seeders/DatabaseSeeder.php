<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => '2025-07-18 10:00:38',
            'password' => '$2y$12$5c1yqfTQKAZr7A1cVmlcjefBrDfHoH4Oj.r7atdxpni5mHukB3iFK',
            'remember_token' => 'onW5iNkRhJpLS1ujXlhYNCopSHePfZDa3GLfrFfWoJL24YVzDAIerZMeuQFR',
        ]);
    }
}