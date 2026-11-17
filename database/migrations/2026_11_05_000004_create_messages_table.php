<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Messages sent from the public website:
     *  - "inquiry"  : Contact Us → Inquiry form
     *  - "question" : FAQ → Ask a question form
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);                  // inquiry | question
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->string('office')->nullable();
            $table->text('body');
            $table->string('status', 20)->default('new'); // new | read | replied
            $table->text('admin_note')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
