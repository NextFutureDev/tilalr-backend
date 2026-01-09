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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->text('paragraph_en');
            $table->text('paragraph_ar');
            $table->string('mission_title_en');
            $table->string('mission_title_ar');
            $table->text('mission_paragraph_en');
            $table->text('mission_paragraph_ar');
            $table->string('vision_title_en');
            $table->string('vision_title_ar');
            $table->text('vision_paragraph_en');
            $table->text('vision_paragraph_ar');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
