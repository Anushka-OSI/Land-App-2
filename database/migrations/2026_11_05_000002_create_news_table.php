<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category', 20);              // News | Notice | Event
            $table->string('excerpt', 500);
            $table->longText('body')->nullable();
            $table->date('published_at');
            $table->boolean('is_published')->default(true);
            $table->boolean('show_on_homepage')->default(false);
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
