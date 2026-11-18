<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Contact Us → Head Office divisions and Regional Offices, managed in the admin panel.
 * Entries are in English, Sinhala (_si) and Tamil (_ta). The tables start empty – every
 * division, officer and office is entered by the admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('head_office_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('division');
            $table->string('division_si')->nullable();
            $table->string('division_ta')->nullable();
            $table->string('position')->nullable();
            $table->string('position_si')->nullable();
            $table->string('position_ta')->nullable();
            $table->string('officer')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('extension', 20)->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('regional_offices', function (Blueprint $table) {
            $table->id();
            $table->string('province', 30)->index();
            $table->string('name');
            $table->string('name_si')->nullable();
            $table->string('name_ta')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('address_si', 500)->nullable();
            $table->string('address_ta', 500)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regional_offices');
        Schema::dropIfExists('head_office_divisions');
    }
};
