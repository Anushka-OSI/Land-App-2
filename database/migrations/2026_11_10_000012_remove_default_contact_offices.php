<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Removes the default Head Office divisions (with their officers) and Regional Offices that an earlier
 * version added automatically when the contact office tables were created. These are now entered by
 * the admin in Admin → Head Office / Regional Offices.
 *
 * Only rows that still have a default name and were never edited (updated_at = created_at) are removed,
 * so anything the admin has added or changed is kept.
 */
return new class extends Migration
{
    private const DIVISIONS = [
        'Office of the Commissioner General', 'Land Division', 'Admin Division', 'Accounts Division',
        'Investigation Division', 'Publication Division', 'Computer Division', 'Planning Division',
        'Record Room', 'Stores', 'Translation Section', 'Legal Section',
    ];

    private const DISTRICTS = [
        'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya', 'Galle', 'Matara', 'Hambantota',
        'Jaffna', 'Kilinochchi', 'Mannar', 'Vavuniya', 'Mullaitivu', 'Batticaloa', 'Ampara', 'Trincomalee',
        'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla', 'Monaragala', 'Ratnapura', 'Kegalle',
    ];

    public function up(): void
    {
        DB::table('head_office_divisions')
            ->whereIn('division', self::DIVISIONS)
            ->whereColumn('updated_at', 'created_at')
            ->delete();

        DB::table('regional_offices')
            ->whereIn('name', array_map(fn ($district) => "Title Settlement Office – {$district}", self::DISTRICTS))
            ->whereColumn('updated_at', 'created_at')
            ->delete();
    }

    public function down(): void
    {
        // The default offices are not restored – they are entered in the admin panel.
    }
};
