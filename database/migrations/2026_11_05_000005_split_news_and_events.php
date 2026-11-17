<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * - News & Notices: drop the News/Notice/Event category, add a language.
 * - Events: their own table, plus up to 10 images per event.
 * Existing "Event" rows in the news table are moved to the events table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('language', 2)->default('en');   // en | si | ta
            $table->string('excerpt', 500);
            $table->longText('body')->nullable();            // sanitized rich-text HTML
            $table->date('event_date');
            $table->boolean('is_published')->default(true);
            $table->boolean('show_on_homepage')->default(false);
            $table->timestamps();

            $table->index(['is_published', 'event_date']);
        });

        Schema::create('event_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('language', 2)->default('en')->after('title');
        });

        // Move old "Event" news items into the events table
        $now = now();
        foreach (DB::table('news')->where('category', 'Event')->get() as $row) {
            DB::table('events')->insert([
                'title'            => $row->title,
                'language'         => 'en',
                'excerpt'          => $row->excerpt,
                'body'             => $row->body ? '<p>' . nl2br(e($row->body)) . '</p>' : null,
                'event_date'       => $row->published_at,
                'is_published'     => $row->is_published,
                'show_on_homepage' => $row->show_on_homepage,
                'created_at'       => $row->created_at ?? $now,
                'updated_at'       => $now,
            ]);
        }
        DB::table('news')->where('category', 'Event')->delete();

        // Old plain-text bodies → simple HTML paragraphs for the rich-text editor
        foreach (DB::table('news')->whereNotNull('body')->where('body', '!=', '')->get() as $row) {
            if (!str_starts_with(ltrim($row->body), '<')) {
                DB::table('news')->where('id', $row->id)->update(['body' => '<p>' . nl2br(e($row->body)) . '</p>']);
            }
        }

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('category', 20)->default('News')->after('title');
        });

        foreach (DB::table('events')->get() as $row) {
            DB::table('news')->insert([
                'title'            => $row->title,
                'category'         => 'Event',
                'language'         => $row->language,
                'excerpt'          => $row->excerpt,
                'body'             => $row->body,
                'published_at'     => $row->event_date,
                'is_published'     => $row->is_published,
                'show_on_homepage' => $row->show_on_homepage,
                'created_at'       => $row->created_at,
                'updated_at'       => $row->updated_at,
            ]);
        }

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::dropIfExists('event_images');
        Schema::dropIfExists('events');
    }
};
