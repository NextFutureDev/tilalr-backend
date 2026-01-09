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
        Schema::create('international_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name_en'); // Hotel name in English
            $table->string('name_ar'); // Hotel name in Arabic
            $table->string('location_en'); // Location in English
            $table->string('location_ar'); // Location in Arabic
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->integer('rating')->default(5);
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->json('amenities_en')->nullable();
            $table->json('amenities_ar')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_hotels');
    }
};
