<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with the initial website content.
     * Admin accounts are created with: php artisan admin:create
     */
    public function run(): void
    {
        $this->call([
            NewsSeeder::class,
            EventSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
