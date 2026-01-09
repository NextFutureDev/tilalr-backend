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
        Schema::create('international_packages', function (Blueprint $table) {
            $table->id();
            $table->string('type_en'); // Early Bird, Family, etc.
            $table->string('type_ar');
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('image')->nullable();
            $table->string('duration_en')->nullable();
            $table->string('duration_ar')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('discount')->nullable();
            $table->json('features_en')->nullable();
            $table->json('features_ar')->nullable();
            $table->string('highlight_en')->nullable();
            $table->string('highlight_ar')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_packages');
    }
};
