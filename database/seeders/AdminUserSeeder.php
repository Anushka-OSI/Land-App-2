<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

/**
 * Creates (or resets) the admin login for the admin panel at /admin.
 *
 *   php artisan db:seed --class=AdminUserSeeder
 *
 * Login details come from .env:  ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD.
 * Without them, local development uses the defaults below. In production ADMIN_PASSWORD
 * must be set, so the default password can never be used on the live site.
 */
class AdminUserSeeder extends Seeder
{
    private const DEFAULT_NAME = 'Administrator';
    private const DEFAULT_EMAIL = 'admin@landtitle.gov.lk';
    private const DEFAULT_PASSWORD = 'Admin@12345';

    public function run(): void
    {
        $name = env('ADMIN_NAME') ?: self::DEFAULT_NAME;
        $email = env('ADMIN_EMAIL') ?: self::DEFAULT_EMAIL;
        $password = env('ADMIN_PASSWORD');

        if (blank($password)) {
            if (app()->environment('production')) {
                throw new RuntimeException('Set ADMIN_PASSWORD (and ADMIN_EMAIL) in .env before seeding the admin user in production.');
            }
            $password = self::DEFAULT_PASSWORD;
        }

        if (strlen($password) < 8) {
            throw new RuntimeException('ADMIN_PASSWORD must be at least 8 characters.');
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: $name;
        $user->password = $password; // hashed by the User model
        $user->is_admin = true;
        $user->email_verified_at ??= now();
        $user->save();

        $this->command?->info("Admin user ready: {$email}" . ($password === self::DEFAULT_PASSWORD ? ' (default password – change it after logging in)' : ''));
    }
}
