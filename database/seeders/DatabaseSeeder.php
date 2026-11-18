<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with the initial website content.
     * The admin login comes from AdminUserSeeder (ADMIN_EMAIL / ADMIN_PASSWORD in .env),
     * or create more admins with: php artisan admin:create
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            // NewsSeeder::class,
            // EventSeeder::class,
            FaqSeeder::class,
            // Head Office address, map location and a few divisions (never overwrites the admin's changes).
            // Regional Offices are not seeded – the admin enters them in Admin → Regional Offices.
            HeadOfficeSeeder::class,
        ]);
    }
}
