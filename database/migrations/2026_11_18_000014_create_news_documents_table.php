<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Documents (PDF, Word, Excel …) attached to a News item / Notice.
 * Files are kept on the private "local" disk (storage/app/news-documents/{news_id}) and served by
 * NewsController::document, so documents of unpublished items cannot be opened by visitors.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->string('language', 5)->nullable();   // en | si | ta, null = all languages
            $table->string('name');                       // name shown on the website
            $table->string('original_name');              // file name as uploaded
            $table->string('path');
            $table->string('extension', 10);
            $table->unsignedBigInteger('size');           // bytes
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_documents');
    }
};
