<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * One News item / Notice / Event can now be written in English, Sinhala AND Tamil:
 * title_xx, excerpt_xx and body_xx per language (instead of one "language" + title/excerpt/body).
 * Existing content is copied into the columns of the language it was written in.
 */
return new class extends Migration
{
    private const TABLES = ['news', 'events'];
    private const LANGS = ['en', 'si', 'ta'];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $t) {
                foreach (self::LANGS as $lang) {
                    $t->string("title_{$lang}")->nullable();
                    $t->string("excerpt_{$lang}", 500)->nullable();
                    $t->longText("body_{$lang}")->nullable();
                }
            });

            foreach (DB::table($table)->get() as $row) {
                $lang = in_array($row->language, self::LANGS, true) ? $row->language : 'en';
                DB::table($table)->where('id', $row->id)->update([
                    "title_{$lang}" => $row->title,
                    "excerpt_{$lang}" => $row->excerpt,
                    "body_{$lang}" => $row->body,
                ]);
            }

            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn(['title', 'excerpt', 'body', 'language']);
            });
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->string('title')->default('');
                $t->string('language', 2)->default('en');
                $t->string('excerpt', 500)->default('');
                $t->longText('body')->nullable();
            });

            // Keep the first language that has content
            foreach (DB::table($table)->get() as $row) {
                foreach (self::LANGS as $lang) {
                    if (filled($row->{"title_{$lang}"})) {
                        DB::table($table)->where('id', $row->id)->update([
                            'title' => $row->{"title_{$lang}"},
                            'language' => $lang,
                            'excerpt' => (string) $row->{"excerpt_{$lang}"},
                            'body' => $row->{"body_{$lang}"},
                        ]);
                        break;
                    }
                }
            }

            Schema::table($table, function (Blueprint $t) {
                $columns = [];
                foreach (self::LANGS as $lang) {
                    array_push($columns, "title_{$lang}", "excerpt_{$lang}", "body_{$lang}");
                }
                $t->dropColumn($columns);
            });
        }
    }
};
