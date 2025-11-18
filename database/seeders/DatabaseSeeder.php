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
        $this->call([
            AdminUserSeeder::class,
            // ProductSeeder::class,        // Add when product schema is ready
            // UserOrderSeeder::class,      // Add when order schema is ready
        ]);
    }
}
