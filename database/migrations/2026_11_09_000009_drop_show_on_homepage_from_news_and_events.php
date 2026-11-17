<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The homepage now shows the latest 5 published News & Notices / Events automatically,
 * so the manual "Show on homepage" flag is no longer needed.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['news', 'events'] as $table) {
            if (Schema::hasColumn($table, 'show_on_homepage')) {
                Schema::table($table, fn (Blueprint $t) => $t->dropColumn('show_on_homepage'));
            }
        }
    }

    public function down(): void
    {
        foreach (['news', 'events'] as $table) {
            if (! Schema::hasColumn($table, 'show_on_homepage')) {
                Schema::table($table, fn (Blueprint $t) => $t->boolean('show_on_homepage')->default(false));
            }
        }
    }
};
