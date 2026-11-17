<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sinhala and Tamil versions of each FAQ.
 * `question` / `answer` stay as the English (required) version; the others are optional
 * and the English text is shown when a translation is empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('question_si')->nullable()->after('answer');
            $table->text('answer_si')->nullable()->after('question_si');
            $table->string('question_ta')->nullable()->after('answer_si');
            $table->text('answer_ta')->nullable()->after('question_ta');
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['question_si', 'answer_si', 'question_ta', 'answer_ta']);
        });
    }
};
