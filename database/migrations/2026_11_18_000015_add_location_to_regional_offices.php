<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Map location of each regional office (set in Admin → Regional Offices with the map picker).
 * The Head Office location is stored in site_settings (head_office.latitude / head_office.longitude).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('regional_offices', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('email');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('regional_offices', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
