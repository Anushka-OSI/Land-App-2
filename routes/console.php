<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
| Create (or promote) an admin user for the admin dashboard:
|   php artisan admin:create
*/
Artisan::command('admin:create {--name=} {--email=}', function () {
    $name = $this->option('name') ?: $this->ask('Name');
    $email = $this->option('email') ?: $this->ask('Email');
    $password = $this->secret('Password (min 8 characters)');
    $confirm = $this->secret('Confirm password');

    $validator = Validator::make(
        ['name' => $name, 'email' => $email, 'password' => $password, 'password_confirmation' => $confirm],
        [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]
    );

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }
        return 1;
    }

    $user = User::where('email', $email)->first();

    if ($user && !$this->confirm("A user with {$email} already exists. Make them an admin and reset their password?", true)) {
        return 1;
    }

    $user ??= new User(['email' => $email]);
    $user->name = $name;
    $user->password = $password;   // hashed automatically (User $casts)
    $user->is_admin = true;
    $user->save();

    $this->info("Admin account ready: {$email}");
    $this->line('Log in at ' . route('admin.login'));

    return 0;
})->purpose('Create an admin user for the admin dashboard');

Artisan::command('calendar:sync-holidays', function (\App\Services\SriLankaHolidaySync $sync) {
    $this->info('Downloading Sri Lankan public holidays and Poya days...');

    try {
        $counts = $sync->sync();
    } catch (\Throwable $e) {
        $this->error('Sync failed: ' . $e->getMessage());

        return 1;
    }

    $this->info("Done. Added {$counts['added']}, updated {$counts['updated']}, removed {$counts['removed']}.");

    return 0;
})->purpose('Update the event calendar with Sri Lankan public holidays and Poya days');
