<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Event photos now belong to one language (English / Sinhala / Tamil tab).
 * Existing photos are given to the first language their event is written in.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_images', function (Blueprint $table) {
            $table->string('language', 2)->default('en')->after('event_id');
            $table->index(['event_id', 'language']);
        });

        foreach (DB::table('events')->get() as $event) {
            $lang = collect(['en', 'si', 'ta'])->first(fn ($l) => filled($event->{"title_{$l}"})) ?? 'en';
            DB::table('event_images')->where('event_id', $event->id)->update(['language' => $lang]);
        }
    }

    public function down(): void
    {
        Schema::table('event_images', function (Blueprint $table) {
            $table->dropIndex(['event_id', 'language']);
            $table->dropColumn('language');
        });
    }
};
