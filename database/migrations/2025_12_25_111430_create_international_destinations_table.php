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
        Schema::create('international_destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name_en'); // Destination name in English
            $table->string('name_ar'); // Destination name in Arabic
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_destinations');
    }
};
