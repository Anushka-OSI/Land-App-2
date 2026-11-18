<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Event calendar shown on every page.
 *  - source "auto":  Sri Lankan public holidays and Poya days, synced by `php artisan calendar:sync-holidays`.
 *  - source "admin": department events, special holidays and special working days (Admin → Event Calendar).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_entries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);            // event | holiday | poya | special_holiday | working_day
            $table->string('source', 10)->default('admin'); // admin | auto
            $table->string('external_uid')->nullable()->unique(); // id in the holiday feed (auto entries)
            $table->date('start_date');
            $table->date('end_date')->nullable();   // multi-day events / holidays
            $table->time('start_time')->nullable();
            $table->string('title_en');
            $table->string('title_si')->nullable();
            $table->string('title_ta')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_si')->nullable();
            $table->text('description_ta')->nullable();
            $table->boolean('is_published')->default(true); // auto entries: false = hidden by the admin
            $table->timestamps();

            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_entries');
    }
};
