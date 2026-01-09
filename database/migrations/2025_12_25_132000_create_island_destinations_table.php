<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('island_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ar');
            $table->string('type_en')->nullable();
            $table->string('type_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('location_en')->nullable();
            $table->string('location_ar')->nullable();
            $table->string('duration_en')->nullable();
            $table->string('duration_ar')->nullable();
            $table->string('groupSize_en')->nullable();
            $table->string('groupSize_ar')->nullable();
            $table->string('price')->nullable();
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->string('image')->nullable();
            $table->json('features_en')->nullable();
            $table->json('features_ar')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('island_destinations');
    }
};
