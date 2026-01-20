<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // location, phone, email
            $table->json('title'); // Translatable title
            $table->json('content'); // Translatable content (address, phone numbers, emails)
            $table->string('icon'); // Bootstrap icon class
            $table->string('working_hours')->nullable(); // For phone card
            $table->integer('sort_order')->default(0); // For ordering cards
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
